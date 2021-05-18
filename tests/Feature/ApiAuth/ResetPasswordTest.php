<?php

namespace Tests\Feature\ApiAuth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;

class ResetPasswordTest extends ApiAuthTestCase
{
    /** @test */
    public function canResetPasswordWithValidToken()
    {
        $response = $this->attemptResetPassword();

        $response->assertStatus(200);
        $this->assertTrue(Hash::check('new-password', $response->user->fresh()->password));
    }

    /** @test */
    public function cannotResetPasswordWithInvalidToken()
    {
        $response = $this->attemptResetPasswordAndExpectFail([
            'token' => 'invalid',
        ], [
            'email' => Lang::get('passwords.token'),
        ]);

        $this->assertSame($response->user->password, $response->user->fresh()->password);
    }

    /** @test */
    public function emailDoesNotChangeWhenResettingPassword()
    {
        $response = $this->attemptResetPassword();

        $response->assertStatus(200);
        $this->assertSame($response->user->email, $response->user->fresh()->email);
    }

    /** @test */
    public function emailFieldIsRequired()
    {
        $this->attemptResetPasswordAndExpectFail(['email' => ''], 'email');
    }

    public function emailFieldMustBeValidEmail()
    {
        $this->attemptResetPasswordAndExpectFail([
            'email' => 'not-an-email',
        ], [
            'email' => Lang::get('validation.email', ['attribute' => 'email']),
        ]);
    }

    /** @test */
    public function guestGetsLoggedInAutomaticallyAfterRestting()
    {
        $response = $this->attemptResetPassword();

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($response->user);
    }

    /** @test */
    public function passwordFieldIsRequired()
    {
        $this->attemptResetPasswordAndExpectFail([
            'password' => '',
            'password_confirmation' => '',
        ], 'password');
    }

    /** @test */
    public function passwordFieldMustBeAtLeast8Characters()
    {
        $this->attemptResetPasswordAndExpectFail([
            'password' => 'short',
            'password_confirmation' => 'short',
        ], [
            'password' => Lang::get('validation.min.string', [
                'attribute' => 'password',
                'min' => '8',
            ]),
        ]);
    }

    /** @test */
    public function passwordFieldMustBeConfirmed()
    {
        $this->attemptResetPasswordAndExpectFail([
            'password' => 'password',
            'password_confirmation' => '',
        ], [
            'password' => Lang::get('validation.confirmed', ['attribute' => 'password']),
        ]);
    }

    /** @test */
    public function tokenFieldIsRequired()
    {
        $this->attemptResetPasswordAndExpectFail([
            'token' => '',
        ], 'token');
    }

    /** @test */
    public function userCannotResetPasswordOfAnotherUser()
    {
        $anotherUser = User::factory()->create();

        // send a different email address. Token won't match, so it should fail
        $this->attemptResetPasswordAndExpectFail([
            'email' => $anotherUser->email,
        ], [
            'email' => Lang::get('passwords.token'),
        ]);
    }

    protected function attemptResetPassword(array $params = [])
    {
        $user = $this->createUser();

        $response = $this->postJson($this->passwordResetRoute, array_merge([
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
            'token' => Password::createToken($user),
        ], $params));

        // so we can make additional assertions about the user
        $response->user = $user;

        return $response;
    }

    /**
     * @param array $params
     * @param array|string $errors
     */
    protected function attemptResetPasswordAndExpectFail(array $params, $errors)
    {
        $response = $this->attemptResetPassword($params);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($errors);

        return $response;
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}
