<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseController extends Controller
{
    public function setupDatabase()
    {
        try {
            // First, try to create the database
            $databaseName = config('database.connections.mysql.database');
            $host = config('database.connections.mysql.host');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            
            // Create database connection without specifying database
            $pdo = new \PDO("mysql:host={$host}", $username, $password);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$databaseName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            
            // Now run migrations
            \Artisan::call('migrate', ['--force' => true]);
            
            // Create admin user
            $admin = User::firstOrCreate(
                ['email' => 'admin@electro.com'],
                [
                    'name' => 'Admin User',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Database setup completed successfully!',
                'admin_credentials' => [
                    'email' => 'admin@electro.com',
                    'password' => 'password'
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database setup failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function createAdminUser()
    {
        try {
            $admin = User::firstOrCreate(
                ['email' => 'admin@electro.com'],
                [
                    'name' => 'Admin User',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Admin user created successfully',
                'user' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'password' => 'password'
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create admin user: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function setupSQLite()
    {
        try {
            // Switch to SQLite
            config(['database.default' => 'sqlite']);
            config(['database.connections.sqlite.database' => database_path('database.sqlite')]);
            
            // Create SQLite database file if it doesn't exist
            if (!file_exists(database_path('database.sqlite'))) {
                touch(database_path('database.sqlite'));
            }
            
            // Run migrations
            \Artisan::call('migrate', ['--force' => true]);
            
            // Create admin user
            $admin = User::firstOrCreate(
                ['email' => 'admin@electro.com'],
                [
                    'name' => 'Admin User',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'SQLite database setup completed successfully!',
                'database' => 'SQLite'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'SQLite setup failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function testConnection()
    {
        try {
            DB::connection()->getPdo();
            return response()->json([
                'success' => true,
                'message' => 'Database connection successful',
                'database' => DB::connection()->getDatabaseName()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
