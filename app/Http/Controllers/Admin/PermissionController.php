<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-permissions');
    }

    public function index(Request $request)
    {
        $query = Permission::orderBy('module')->orderBy('name');

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%");
        }

        $permissions = $query->paginate(20)->withQueryString();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $modules = Permission::select('module')->distinct()->pluck('module')->filter()->sort();
        return view('admin.permissions.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:permissions,slug',
            'module' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        Permission::create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? Str::slug($data['name']),
            'module' => $data['module'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        $modules = Permission::select('module')->distinct()->pluck('module')->filter()->sort();
        return view('admin.permissions.edit', compact('permission', 'modules'));
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('permissions', 'slug')->ignore($permission->id)],
            'module' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        $permission->update([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? $permission->slug,
            'module' => $data['module'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->roles()->detach();
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
