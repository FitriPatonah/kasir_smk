<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RiwayatTransaksiTest extends TestCase
{
    use WithoutMiddleware;

    public function test_riwayat_transaksi_page_can_be_rendered(): void
    {
        $response = $this->get(route('riwayat.transaksi'));

        $response->assertOk();
        $response->assertSee('Riwayat Transaksi');
    }
}
