<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RiwayatTransaksiTest extends TestCase
{
    use RefreshDatabase;

    public function test_riwayat_transaksi_page_can_be_rendered(): void
    {
        $kasir = User::factory()->create([
            'role' => 'kasir',
        ]);

        $response = $this->actingAs($kasir, 'kasir')
            ->get(route('kasir.riwayat'));

        $response->assertOk();
        $response->assertSee('Riwayat Transaksi');
    }
}
