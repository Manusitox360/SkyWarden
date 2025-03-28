<?php

namespace Tests\Feature;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the registration of a user (role should default to 'user').
     *
     * @return void
     */
    public function test_guest_can_register()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson(route('auth.Register'), $data);

        // Assert that registration is successful and the role is 'user' by default
        $response->assertStatus(201)
                 ->assertJsonFragment(['role' => 'user']); // Role should default to 'user'
    }

    /**
     * Test that admin can update user role.
     *
     * @return void
     */
    public function test_admin_can_update_user_role()
    {
        // Create an admin user and login
        $admin = User::factory()->create(['role' => 'admin']);
        $token = JWTAuth::fromUser($admin);

        // Create a regular user
        $user = User::factory()->create(['role' => 'user']);

        // Update the user's role to 'admin'
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->putJson(route('ApiUpdateUsers', $user->id), [
            'role' => 'admin',
        ]);

        // Assert that the response is successful and the role is updated
        $response->assertStatus(200)
                 ->assertJsonFragment(['role' => 'admin']);
    }

    /**
     * Test that non-admin cannot update user role.
     *
     * @return void
     */
    public function test_non_admin_cannot_update_user_role()
    {
        // Create a regular user and login
        $user = User::factory()->create(['role' => 'user']);
        $token = JWTAuth::fromUser($user);

        // Attempt to update the user's role
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->putJson(route('ApiUpdateUsers', $user->id), [
            'role' => 'admin',
        ]);

        // Assert that the response is forbidden (403)
        $response->assertStatus(403)
                 ->assertJsonFragment(['message' => 'Unauthorized - Admins only']);
    }

    /**
     * Test the login functionality and validate token structure.
     *
     * @return void
     */
    public function test_login_and_get_token()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->postJson(route('auth.Login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        // Assert the response contains a token
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'access_token',
                     'token_type',
                     'expires_in',
                 ]);
    }

    /**
     * Test the logout functionality.
     *
     * @return void
     */
    public function test_logout()
    {
        // Create a user and login to get the token
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson(route('auth.Logout'));

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Logged out successfully']);
    }

    /**
     * Test retrieving the authenticated user.
     *
     * @return void
     */
    public function test_get_authenticated_user()
    {
        // Create a user and login to get the token
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson(route('auth.Me'));

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $user->id]);
    }

    /**
     * Test token refresh functionality.
     *
     * @return void
     */
    public function test_refresh_token()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson(route('auth.Refresh'));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'access_token',
                     'token_type',
                     'expires_in',
                 ]);
    }
}

