<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-users');
    }

    public function index(Request $request)
    {
        $query = User::with(['role', 'roles'])->orderBy('name');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($role = $request->get('role')) {
            $query->where(function ($q) use ($role) {
                $q->where('role', $role)
                  ->orWhereHas('roles', fn ($r) => $r->where('slug', $role));
            });
        }

        if ($status = $request->get('status')) {
            if (in_array($status, ['active', 'inactive'])) {
                $query->where('is_active', $status === 'active');
            }
        }

        $users = $query->paginate(15)->withQueryString();
        $roles = Role::active()->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::active()->orderBy('name')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'nullable|exists:roles,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'is_active' => 'nullable|boolean',
        ]);

        $user = null;

        DB::transaction(function () use (&$user, $data, $request) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'role_id' => $data['role_id'] ?? ($data['roles'][0] ?? null),
                'role' => optional(Role::find($data['role_id'] ?? ($data['roles'][0] ?? null)))->slug ?? 'staff',
                'is_active' => $request->boolean('is_active', true),
            ]);

            if (!empty($data['roles'])) {
                $user->assignRole($data['roles']);
            } elseif ($data['role_id']) {
                $user->assignRole([$data['role_id']]);
            }

            $user->ensurePrimaryRole();
        });

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load(['roles.permissions']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::active()->orderBy('name')->get();
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'nullable|exists:roles,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'is_active' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request, $user, $data) {
            $payload = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'role_id' => $data['role_id'] ?? ($data['roles'][0] ?? null),
                'is_active' => $request->boolean('is_active', true),
            ];

            if (!empty($data['password'])) {
                $payload['password'] = Hash::make($data['password']);
            }

            if ($payload['role_id']) {
                $payload['role'] = optional(Role::find($payload['role_id']))->slug ?? $user->role;
            }

            $user->update($payload);

            if (!empty($data['roles'])) {
                $user->assignRole($data['roles']);
            } elseif ($data['role_id']) {
                $user->assignRole([$data['role_id']]);
            }

            $user->ensurePrimaryRole();
        });

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->withErrors('You cannot delete your own account.');
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
