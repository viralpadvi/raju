<?php

namespace Tests\Feature\Api\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_receive_token(): void
    {
        $password = 'password123';
        $admin = User::factory()->create([
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $response = $this->postJson('/api/admin/auth/login', [
            'email' => $admin->email,
            'password' => $password,
            'device_name' => 'test-device',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'status',
                'token_type',
                'access_token',
                'user' => ['id', 'email', 'role'],
            ]);
    }

    public function test_non_admin_is_rejected_from_login(): void
    {
        $password = 'password123';
        $staff = User::factory()->create([
            'password' => Hash::make($password),
            'role' => 'staff',
        ]);

        $response = $this->postJson('/api/admin/auth/login', [
            'email' => $staff->email,
            'password' => $password,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_routes_require_authentication(): void
    {
        $response = $this->getJson('/api/admin/catalog/brands');

        $response->assertStatus(401);
    }

    public function test_brand_crud_flow(): void
    {
        $this->actingAsAdmin();

        $create = $this->postJson('/api/admin/catalog/brands', [
            'name' => 'Test Brand',
            'description' => 'Sample',
            'website' => 'https://example.com',
            'is_active' => true,
        ]);

        $create->assertStatus(200)->assertJsonPath('data.name', 'Test Brand');

        $brandId = $create->json('data.id');

        $index = $this->getJson('/api/admin/catalog/brands');
        $index->assertStatus(200)->assertJsonFragment(['name' => 'Test Brand']);

        $update = $this->putJson("/api/admin/catalog/brands/{$brandId}", [
            'name' => 'Updated Brand',
            'is_active' => false,
        ]);

        $update->assertStatus(200)->assertJsonPath('data.name', 'Updated Brand');

        $delete = $this->deleteJson("/api/admin/catalog/brands/{$brandId}");
        $delete->assertStatus(200);

        $this->assertDatabaseMissing('brands', ['id' => $brandId]);
    }

    protected function actingAsAdmin(): User
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        Sanctum::actingAs($user, ['admin']);

        return $user;
    }
}

