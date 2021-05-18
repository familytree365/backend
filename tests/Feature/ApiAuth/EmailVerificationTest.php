<?php

namespace Tests\Feature\ApiAuth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class EmailVerificationTest extends ApiAuthTestCase
{
    /** @test */
    public function canVerify()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $this->assertFalse($user->hasVerifiedEmail());
        $this->actingAs($user);

        $response = $this->getJson($this->verifyRoute($user));
        $response->assertStatus(204);
        $this->assertTrue($user->hasVerifiedEmail());
    }

    /** @test */
    public function emailIsSentUponRegistering()
    {
        $this->postJson($this->registerRoute, [
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => $this->validEmail,
            'password' => $this->validPassword,
            'password_confirmation' => $this->validPassword,
        ]);

        $this->assertEmailSentTo(User::find(1));
    }

    /** @test */
    public function guestCannotResendEmail()
    {
        User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->postJson($this->resendVerificationEmailRoute);
        $response->assertStatus(401);
        $this->assertSame('Unauthenticated.', $response->json('message'));

        Notification::assertNothingSent();
    }

    /** @test */
    public function mustBeLoggedInToVerify()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->assertFalse($user->hasVerifiedEmail());
        $this->assertGuest();

        $response = $this->getJson($this->verifyRoute($user));
        $response->assertStatus(401);
        $this->assertSame('Unauthenticated.', $response->json('message'));
    }

    /** @test */
    public function nonVerifiedUserCanResendEmail()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $this->actingAs($user);

        $response = $this->postJson($this->resendVerificationEmailRoute);
        $response->assertStatus(202);
        $this->assertEmailSentTo($user);
    }

    /** @test */
    public function userCannotVerifyAnotherUser()
    {
        $user1 = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $user2 = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->assertFalse($user2->hasVerifiedEmail());
        $this->assertFalse($user1->hasVerifiedEmail());

        $this->actingAs($user1);

        $response = $this->getJson($this->verifyRoute($user2));
        $response->assertStatus(403);
        $this->assertSame('This action is unauthorized.', $response->json('message'));
    }

    /** @test */
    public function verifiedUserCannotResendEmail()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        $response = $this->postJson($this->resendVerificationEmailRoute);
        $response->assertStatus(204);
        Notification::assertNothingSent();
    }

    protected function assertEmailSentTo(User $user)
    {
        Notification::assertSentTo($user, VerifyEmail::class, function ($notification, $channel, $notifiable) use ($user
        ) {
            return $user->is($notifiable);
        });
    }

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    protected function verifyRoute(User $user)
    {
        return URL::temporarySignedRoute('verification.verify', Carbon::now()
            ->addMinutes(Config::get('auth.verification.expire', 60)), [
            'id' => $user->getKey(), // i.e. $user->id
            'hash' => sha1($user->getEmailForVerification()), // i.e. $user->email
        ]);
    }
}
