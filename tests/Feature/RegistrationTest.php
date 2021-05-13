<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    // use RefreshDatabase;


    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->getJson('/api/register');

        $response->assertStatus(405);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/api/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticatedAs($response);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
