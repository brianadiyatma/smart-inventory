<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function test_the_application_returns_a_successful_response()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    // public function test()
    // {
    //     $response = $this->get('/api/dokumen');

    //     $response->assertStatus(200);
    // }

    //group inbound API
    public function test_inbound_get()
    {
        $response = $this->get('/api/inbound');

        $response->assertStatus(200);
    }

    public function test_inbound_post()
    {
        $response = $this->post('/api/inbound');

        $response->assertStatus(200);
    }

    public function test_inbound_get_with_param($id)
    {
        $response = $this->get('/api/inbound/{id}');

        $response->assertStatus(200);
    }

    public function test_inbound_post_with_param($id)
    {
        $response = $this->put('/api/inbound/{id}');

        $response->assertStatus(200);
    }

    public function test_inbound_delete($id)
    {
        $response = $this->delete('/api/inbound/{id}');

        $response->assertStatus(200);
    }

    public function test_sttp()
    {
        $response = $this->get('/api/sttp');

        $response->assertStatus(200);
    }

    public function test_sttp_with_param($id)
    {
        $response = $this->get('/api/sttp/{id}');

        $response->assertStatus(200);
    }

    public function test_sttp_transaksi()
    {
        $response = $this->get('/api/sttp-transaksi');

        $response->assertStatus(200);
    }

    public function test_sttp_selesai($id)
    {
        $response = $this->get('/api/sttp-selesai/{id}');

        $response->assertStatus(200);
    }

    //========================================================
    //========================================================

    //group outbound API
    public function test_outbound_get()
    {
        $response = $this->get('/api/outbound');

        $response->assertStatus(200);
    }

    public function test_outbound_post()
    {
        $response = $this->post('/api/outbound');

        $response->assertStatus(200);
    }

    public function test_outbound_get_with_param($id)
    {
        $response = $this->get('/api/outbound/{id}');

        $response->assertStatus(200);
    }

    public function test_outbound_post_with_param($id)
    {
        $response = $this->put('/api/outbound/{id}');

        $response->assertStatus(200);
    }

    public function test_outbound_delete($id)
    {
        $response = $this->delete('/api/outbound/{id}');

        $response->assertStatus(200);
    }

    public function test_bpm()
    {
        $response = $this->get('/api/bpm');

        $response->assertStatus(200);
    }

    public function test_bpm_with_param($id)
    {
        $response = $this->get('/api/bpm/{id}');

        $response->assertStatus(200);
    }

    public function test_bpm_transaksi()
    {
        $response = $this->get('/api/bpm-transaksi');

        $response->assertStatus(200);
    }

    public function test_bpm_selesai($id)
    {
        $response = $this->get('/api/bpm-selesai/{id}');

        $response->assertStatus(200);
    }

    //========================================================
    //========================================================

    //group dokumen API
    public function test_dokumen()
    {
        $response = $this->get('/api/dokumen');

        $response->assertStatus(200);
    }

    public function test_dokumen_count()
    {
        $response = $this->get('/api/dokumen');

        $response->assertStatus(200);
    }

    public function test_dokumen_transaksi_belum()
    {
        $response = $this->get('/api/dokumen');

        $response->assertStatus(200);
    }

    public function test_dokumen_material()
    {
        $response = $this->get('/api/dokumen');

        $response->assertStatus(200);
    }

    public function test_dokumen_transaksi_hari()
    {
        $response = $this->get('/api/dokumen');

        $response->assertStatus(200);
    }




}
