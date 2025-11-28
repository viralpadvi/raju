<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'customer' => $this->when($this->relationLoaded('customer'), function () {
                return [
                    'id' => $this->customer->id,
                    'name' => $this->customer->name,
                    'phone' => $this->customer->phone,
                    'email' => $this->customer->email,
                ];
            }),
            'customer_id' => $this->customer_id,
            'delivery_agent' => $this->when($this->relationLoaded('deliveryAgent'), function () {
                return [
                    'id' => $this->deliveryAgent->id,
                    'name' => $this->deliveryAgent->name,
                    'phone' => $this->deliveryAgent->phone,
                    'email' => $this->deliveryAgent->email,
                ];
            }),
            'delivery_agent_id' => $this->delivery_agent_id,
            'status' => $this->status,
            'subtotal' => (float) $this->subtotal,
            'tax_amount' => (float) $this->tax_amount,
            'discount_amount' => (float) $this->discount_amount,
            'total_amount' => (float) $this->total_amount,
            'delivery_address' => $this->delivery_address,
            'delivery_phone' => $this->delivery_phone,
            'delivery_notes' => $this->delivery_notes,
            'assigned_at' => optional($this->assigned_at)->toIso8601String(),
            'picked_up_at' => optional($this->picked_up_at)->toIso8601String(),
            'delivered_at' => optional($this->delivered_at)->toIso8601String(),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}

