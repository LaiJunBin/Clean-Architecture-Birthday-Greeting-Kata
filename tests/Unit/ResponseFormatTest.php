<?php

namespace Tests\Unit;

use App\Repositories\MemberRepository;
use App\Responses\XMLResponse;
use App\Services\ApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponseFormatTest extends TestCase
{
    use RefreshDatabase;

    protected $apiService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiService = new ApiService(new MemberRepository());
    }

    public function test_text()
    {
        $text = 'Hi Hi';
        $response = ApiService::response($text);
        $this->assertEquals($text, $response->content());
    }

    public function test_xml()
    {
        $data = [
            'a' => [
                'aa' => [
                    'aaa' => 1,
                    'aab' => 2
                ],
                'ab' => [
                    'aba' => 3,
                    'abb' => 4
                ],
            ],
            'b' => [
                'bb' => [
                    'bbb' => 1
                ],
                'bc' => [
                    'bcb' => 1
                ]
            ]
        ];

        $response = new XMLResponse($data);
        $expected_xml = '<?xml version="1.0" encoding="UTF-8"?><root><a><aa><aaa>1</aaa><aab>2</aab></aa><ab><aba>3</aba><abb>4</abb></ab></a><b><bb><bbb>1</bbb></bb><bc><bcb>1</bcb></bc></b></root>';
        $this->assertXmlStringEqualsXmlString($expected_xml, $response->content());
    }

    public function test_simpleMessageForBirthDay()
    {
        $this->seed();
        $response = $this->apiService->simpleMessageForBirthDay(8, 8, 'text');
        $this->assertIsString($response->content());

        $response = $this->apiService->simpleMessageForBirthDay(8, 8, 'json');
        $this->assertJson($response->content());

        $response = $this->apiService->simpleMessageForBirthDay(8, 8, 'xml');
        $xml = simplexml_load_string($response->content());
        $json = json_encode($xml);

        $this->assertJson($json);
    }
}
