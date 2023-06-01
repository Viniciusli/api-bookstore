<?php

namespace Tests\Feature\app\Http\Controller;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin, $maneger, $roleAdmin, $roleManeger;

    public function setUp(): void
    {
        parent::setUp();

        $this->setupPermissions();

        $this->maneger = User::factory()->create();
        $this->maneger->assignRole('Book Maneger');

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Super Admin');
    }

    protected function setupPermissions()
    {
        $this->roleAdmin = Role::findOrCreate('Super Admin');
        $this->roleManeger = Role::findOrCreate('Book Maneger');
    }

    public function test_user_can_loggin(): void
    {
        // prepare
        $user = User::factory()->create();

        // act
        $result = $this->post('api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // assert
        $result->assertOk();
        $this->assertNotNull($result['token']);
    }

    public function test_user_can_be_create(): void
    {
        // prepare
        Sanctum::actingAs(
            $this->admin,
        );

        $user = [
            'name' => 'John',
            'email' => 'john@email.com',
            'password' => 'nicepassword123',
        ];
        $role = [
            'role_id' => $this->roleAdmin->id,
        ];
        $payload = $user + $role;

        // // act
        $result = $this->post('/api/user', $payload);

        // // assert
        $result->assertStatus(201);
        $this->assertDatabaseHas('users', $user);
    }

    public function test_only_super_admin_can_create_user()
    {
        // prepare
        $payload = [
            'name' => 'John',
            'email' => 'john@email.com',
            'password' => 'nicepassword123',
        ];

        // act
        $result = $this->post('/api/user', $payload);

        // assert
        $result->assertStatus(403);
    }
}
