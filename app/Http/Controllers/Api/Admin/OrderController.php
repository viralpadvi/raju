<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OrderResource;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'deliveryAgent', 'items']);

        if ($request->filled('delivery_agent_id')) {
            $query->where('delivery_agent_id', $request->integer('delivery_agent_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate($request->integer('per_page', 20));

        return response()->json([
            'data' => OrderResource::collection($orders->items()),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ],
        ]);
    }

    public function show(Order $order)
    {
        return response()->json([
            'data' => new OrderResource($order->load(['customer', 'deliveryAgent', 'items'])),
        ]);
    }

    public function accept(Request $request, Order $order)
    {
        if ($order->status !== 'pending' && $order->status !== 'assigned') {
            return response()->json([
                'message' => 'Order cannot be accepted in current status.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $order->update([
            'status' => 'assigned',
            'delivery_agent_id' => Auth::id(),
            'assigned_at' => now(),
        ]);

        return response()->json([
            'data' => new OrderResource($order->load(['customer', 'deliveryAgent', 'items'])),
        ]);
    }

    public function pickup(Request $request, Order $order)
    {
        if (!in_array($order->status, ['assigned', 'pending'])) {
            return response()->json([
                'message' => 'Order cannot be picked up in current status.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $order->update([
            'status' => 'picked_up',
            'picked_up_at' => now(),
        ]);

        return response()->json([
            'data' => new OrderResource($order->load(['customer', 'deliveryAgent', 'items'])),
        ]);
    }

    public function deliver(Request $request, Order $order)
    {
        if (!in_array($order->status, ['picked_up', 'in_transit'])) {
            return response()->json([
                'message' => 'Order cannot be delivered in current status.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $order->update([
            'status' => 'delivered',
            'delivered_at' => now(),
            'delivery_notes' => $request->input('notes', $order->delivery_notes),
        ]);

        return response()->json([
            'data' => new OrderResource($order->load(['customer', 'deliveryAgent', 'items'])),
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,assigned,picked_up,in_transit,delivered,cancelled'],
        ]);

        $order->update(['status' => $validated['status']]);

        return response()->json([
            'data' => new OrderResource($order->load(['customer', 'deliveryAgent', 'items'])),
        ]);
    }

    public function assign(Request $request, Order $order)
    {
        $validated = $request->validate([
            'delivery_agent_id' => ['required', 'exists:users,id'],
        ]);

        DB::transaction(function () use ($order, $validated) {
            $order->update([
                'status' => 'assigned',
                'delivery_agent_id' => $validated['delivery_agent_id'],
                'assigned_at' => now(),
            ]);

            // Create notification for delivery agent
            Notification::create([
                'user_id' => $validated['delivery_agent_id'],
                'type' => 'order_assigned',
                'title' => 'New Order Assigned',
                'message' => "Order {$order->order_number} has been assigned to you.",
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'is_read' => false,
            ]);
        });

        return response()->json([
            'data' => new OrderResource($order->load(['customer', 'deliveryAgent', 'items'])),
        ]);
    }
}

