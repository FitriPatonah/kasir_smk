<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Tests\TestCase;

class AuthRoleLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_must_confirm_logout_before_opening_login(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin, 'admin')->get(route('login'));

        $response->assertOk();
        $response->assertViewIs('auth.confirm-logout');
        $response->assertSee('logout-confirm-dialog');
        $response->assertDontSee('name="username"');
    }

    public function test_authenticated_kasir_must_confirm_logout_before_opening_login(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);

        $response = $this->actingAs($kasir, 'kasir')->get(route('login'));

        $response->assertOk();
        $response->assertViewIs('auth.confirm-logout');
        $response->assertViewHas('dashboardUrl', route('kasir.index'));
        $response->assertViewHas('logoutUrl', route('auth.logout', ['role' => 'kasir']));
    }

    public function test_selected_role_must_match_user_role(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Test',
            'username' => 'admin_test',
            'email' => 'admin2@kasir.test',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
        ]);

        $response = $this->from(route('auth.login', ['role' => 'kasir']))
            ->post(route('auth.login.post', ['role' => 'kasir']), [
                'username' => $admin->username,
                'password' => 'secret123',
            ]);

        $response->assertSessionHasErrors('username');
        $this->assertFalse(Auth::guard('admin')->check());
        $this->assertFalse(Auth::guard('kasir')->check());
    }

    public function test_user_can_login_with_email(): void
    {
        $user = User::factory()->create([
            'username' => 'kasir_email',
            'email' => 'kasir-email@example.test',
            'password' => Hash::make('secret123'),
            'role' => 'kasir',
        ]);

        $response = $this->post(route('login.post'), [
            'username' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('kasir.index'));
        $this->assertAuthenticatedAs($user, 'kasir');
    }

    public function test_user_can_request_a_password_reset_link(): void
    {
        Notification::fake();
        $user = User::factory()->create(['email' => 'reset@example.test']);

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'Jika email terdaftar, tautan reset password akan dikirim.');
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_user_can_reset_password_with_a_valid_token(): void
    {
        Notification::fake();
        $user = User::factory()->create(['email' => 'reset@example.test']);
        $this->post(route('password.email'), ['email' => $user->email]);

        $token = null;
        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function (ResetPassword $notification) use (&$token): bool {
                $token = $notification->token;

                return true;
            }
        );
        $this->assertNotNull($token);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-secret123',
            'password_confirmation' => 'new-secret123',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertTrue(Hash::check('new-secret123', $user->fresh()->password));
    }
}
