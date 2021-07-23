<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ExceptionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_404()
    {
        $response = $this->get('/');
        $response->assertStatus(404);
    }

    public function test_405()
    {
        $response = $this->delete(route('members.index'));
        $response->assertStatus(405);
    }

    public function test_405_format_json()
    {
        $response = $this->delete(route('members.index', ['format' => 'json']));
        $response->assertStatus(405)->assertJsonStructure(['message']);
    }

    public function test_405_format_xml()
    {
        $response = $this->delete(route('members.index', ['format' => 'xml']));
        $response->assertStatus(405);
        $xml = simplexml_load_string($response->content());
        $json = json_decode(json_encode($xml), true);
        $response = new TestResponse(Response($json));
        $response->assertJsonStructure(['message']);
    }
}
