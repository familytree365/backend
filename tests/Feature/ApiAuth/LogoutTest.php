<?php

namespace Tests\Feature\ApiAuth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LogoutTest extends ApiAuthTestCase
{
    /**
     * Correct
     * @test
     *
     * */
    public function userCanLogout()
    {
        $this->be(User::factory()->create());
        $response = $this->postJson($this->logoutRoute);
        $this->assertNull(Auth::user());
        $this->assertGuest();
    }
}
