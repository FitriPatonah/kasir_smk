<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthRoleLoginTest extends TestCase
{
    use RefreshDatabase;

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
}
