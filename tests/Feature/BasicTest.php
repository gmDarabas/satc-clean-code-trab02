<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicTest extends TestCase
{
    /**
     * Testa se a home responde corretamente.
     */
    public function test_home_page_returns_success()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Testa se a rota /pastas está acessível.
     */
    public function test_pastas_route_returns_success()
    {
        $response = $this->get('/pastas');
        $response->assertStatus(200);
    }

    /**
     * Testa se a rota /torrents está acessível.
     */
    public function test_torrents_route_returns_success()
    {
        $response = $this->get('/torrents');
        $response->assertStatus(200);
    }
}
