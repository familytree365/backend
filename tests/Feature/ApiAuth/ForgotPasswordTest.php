<?php

namespace Tests\Feature\ApiAuth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordTest extends ApiAuthTestCase
{
    /** @test */
    public function testEmailFieldIsRequired()
    {
        $response = $this->postJson($this->passwordEmailRoute, [
            'email' => '',
        ]);
        $response->assertStatus(405);
        Notification::assertNothingSent();
    }

    /** @test */
    public function testEmailFieldMustBeValidEmail()
    {
        $response = $this->postJson($this->passwordEmailRoute, [
            'email' => 'not-an-email',
        ]);

        $response->assertStatus(405);
        Notification::assertNothingSent();
    }

    /** @test */
    public function testEmailIsNotSentToNonRegisteredEmail()
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson($this->passwordEmailRoute, [
            'email' => $this->invalidEmail,
        ]);

        $response->assertStatus(405);
        dd($response->decodeResponseJson());
        $response->assertJsonValidationErrors([
            'email' => Lang::get('passwords.user'),
        ]);

        Notification::assertNothingSent();
    }

    /** @test */
    public function emailIsSentToRegisteredEmail()
    {
        // arrange
        $user = $this->createUser();

        $response = $this->postJson($this->passwordEmailRoute, [
            'email' => $user->email,
        ]);

        $response->assertStatus(200);
        $this->assertSame(Lang::get('passwords.sent'), $response->json('message'));

        Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) {
            return Hash::check($notification->token, DB::table('password_resets')
                    ->first()->token) === true;
        });
    }

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }
}
