<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_role_cannot_access_kasir_routes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin, 'admin')->get(route('kasir.index'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_kasir_role_cannot_access_admin_routes(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);

        $response = $this->actingAs($kasir, 'kasir')->get(route('admin.dashboard'));

        $response->assertRedirect(route('kasir.index'));
    }

    public function test_admin_cannot_open_an_internal_page_by_entering_its_url_directly(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.transaksi'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_kasir_cannot_open_an_internal_page_by_entering_its_url_directly(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);

        $response = $this->actingAs($kasir, 'kasir')->get(route('kasir.riwayat'));

        $response->assertRedirect(route('kasir.index'));
    }

    public function test_kasir_cannot_open_profile_by_entering_its_url_directly(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);

        $response = $this->actingAs($kasir, 'kasir')->get(route('kasir.profil'));

        $response->assertRedirect(route('kasir.index'));
    }

    public function test_admin_can_open_an_internal_page_from_an_application_link(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin, 'admin')
            ->withHeader('referer', route('admin.dashboard'))
            ->get(route('admin.transaksi'));

        $response->assertOk();
    }

    public function test_admin_stays_on_current_menu_when_url_is_changed_to_another_admin_route(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin, 'admin')
            ->withHeader('referer', route('admin.dashboard'))
            ->get(route('admin.transaksi'))
            ->assertOk();

        $response = $this->get(route('admin.produk'));

        $response->assertRedirect(route('admin.transaksi'));
    }

    public function test_kasir_stays_on_current_menu_when_url_is_changed_to_another_kasir_route(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);

        $this->actingAs($kasir, 'kasir')
            ->withHeader('referer', route('kasir.index'))
            ->get(route('kasir.riwayat'))
            ->assertOk();

        $response = $this->get(route('kasir.stok'));

        $response->assertRedirect(route('kasir.riwayat'));
    }

    public function test_kasir_stays_on_current_menu_when_url_is_changed_to_kasir_dashboard(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);

        $this->actingAs($kasir, 'kasir')
            ->withHeader('referer', route('kasir.index'))
            ->get(route('kasir.riwayat'))
            ->assertOk();

        $response = $this->get(route('kasir.index'));

        $response->assertRedirect(route('kasir.riwayat'));
    }

    public function test_admin_stays_on_current_menu_when_url_is_changed_to_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin, 'admin')
            ->withHeader('referer', route('admin.dashboard'))
            ->get(route('admin.transaksi'))
            ->assertOk();

        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.transaksi'));
    }

    public function test_guest_is_redirected_to_login_for_protected_routes(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('kasir.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_kasir_sees_branded_not_found_page_for_an_unknown_url(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);

        $response = $this->actingAs($kasir, 'kasir')->get('/profil');

        $response->assertNotFound();
        $response->assertViewIs('errors.404');
        $response->assertViewHas('homeUrl', route('kasir.index'));
        $response->assertSee('Halaman Tidak Ditemukan');
    }

    public function test_guest_sees_branded_not_found_page_for_an_unknown_url(): void
    {
        $response = $this->get('/profil');

        $response->assertNotFound();
        $response->assertViewIs('errors.404');
        $response->assertViewHas('homeUrl', route('login'));
    }
}