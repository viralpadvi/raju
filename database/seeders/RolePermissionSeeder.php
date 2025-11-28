<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'module' => 'users'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles', 'module' => 'users'],
            ['name' => 'Manage Permissions', 'slug' => 'manage-permissions', 'module' => 'users'],
            ['name' => 'Manage Customers', 'slug' => 'manage-customers', 'module' => 'customers'],
            ['name' => 'View Sales', 'slug' => 'view-sales', 'module' => 'sales'],
            ['name' => 'Download Invoices', 'slug' => 'download-invoices', 'module' => 'sales'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::updateOrCreate(
                ['slug' => $permissionData['slug']],
                [
                    'name' => $permissionData['name'],
                    'module' => $permissionData['module'],
                    'description' => $permissionData['name'],
                ]
            );
        }

        $roleDefinitions = [
            'super-admin' => [
                'name' => 'Super Admin',
                'permissions' => Permission::pluck('id')->toArray(),
            ],
            'manager' => [
                'name' => 'Store Manager',
                'permissions' => Permission::whereIn('slug', [
                    'manage-customers',
                    'view-sales',
                    'download-invoices',
                ])->pluck('id')->toArray(),
            ],
            'cashier' => [
                'name' => 'Cashier',
                'permissions' => Permission::whereIn('slug', [
                    'view-sales',
                    'download-invoices',
                ])->pluck('id')->toArray(),
            ],
        ];

        foreach ($roleDefinitions as $slug => $roleData) {
            $role = Role::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $roleData['name'],
                    'description' => $roleData['name'] . ' role',
                    'is_active' => true,
                ]
            );

            $role->permissions()->sync($roleData['permissions']);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@electro.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        if ($admin) {
            $superAdminRole = Role::where('slug', 'super-admin')->first();
            if ($superAdminRole) {
                $admin->role_id = $superAdminRole->id;
                $admin->role = 'super-admin';
                $admin->save();
                $admin->assignRole([$superAdminRole->id]);
            }
        }
    }
}
