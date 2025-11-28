<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BranchResource;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $query = Branch::with('manager');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->boolean('status'));
        }

        $branches = $query->orderBy('name')->paginate($request->integer('per_page', 15));

        return BranchResource::collection($branches);
    }

    public function store(Request $request): BranchResource
    {
        $validated = $this->validatedData($request);
        $branch = Branch::create($validated);

        return new BranchResource($branch->load('manager'));
    }

    public function show(Branch $branch): BranchResource
    {
        return new BranchResource($branch->load('manager'));
    }

    public function update(Request $request, Branch $branch): BranchResource
    {
        $validated = $this->validatedData($request, $branch->id);
        $branch->update($validated);

        return new BranchResource($branch->load('manager'));
    }

    public function destroy(Branch $branch)
    {
        if ($branch->registers()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete branch with assigned registers.',
            ], 422);
        }

        $branch->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Branch deleted successfully.',
        ]);
    }

    private function validatedData(Request $request, ?int $branchId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', Rule::unique('branches', 'code')->ignore($branchId)],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'manager_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);
    }
}

