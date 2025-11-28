<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RegisterResource;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        $query = Register::with('branch');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->integer('branch_id'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->boolean('status'));
        }

        $registers = $query->orderBy('name')->paginate($request->integer('per_page', 15));

        return RegisterResource::collection($registers);
    }

    public function store(Request $request): RegisterResource
    {
        $validated = $this->validatedData($request);
        $register = Register::create($validated);

        return new RegisterResource($register->load('branch'));
    }

    public function show(Register $register): RegisterResource
    {
        return new RegisterResource($register->load('branch'));
    }

    public function update(Request $request, Register $register): RegisterResource
    {
        $validated = $this->validatedData($request, $register->id);
        $register->update($validated);

        return new RegisterResource($register->load('branch'));
    }

    public function destroy(Register $register)
    {
        if ($register->sales()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete register with recorded sales.',
            ], 422);
        }

        $register->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Register deleted successfully.',
        ]);
    }

    private function validatedData(Request $request, ?int $registerId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', Rule::unique('registers', 'code')->ignore($registerId)],
            'branch_id' => ['required', 'exists:branches,id'],
            'description' => ['nullable', 'string'],
            'initial_cash' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);
    }
}

