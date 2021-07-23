<?php

namespace Tests\Feature;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_json_format()
    {
        $this->seed();
        $response = $this->get(route('members.index'));
        $response->assertJsonStructure(['data' => [
            ['id', 'first_name', 'last_name', 'gender', 'date_of_birthday', 'email', 'created_at', 'updated_at']
        ]]);
    }

    public function test_index_xml_format()
    {
        $this->seed();
        $response = $this->get(route('members.index', ['format' => 'xml']));
        $xml = simplexml_load_string($response->content());
        $json = json_decode(json_encode($xml), true);
        $response = new TestResponse(Response($json));
        $response->assertJsonStructure(['data' => [
            'wrapper' => [['id', 'first_name', 'last_name', 'gender', 'date_of_birthday', 'email', 'created_at', 'updated_at']]
        ]]);
    }

    public function test_index_text_format()
    {
        $this->seed();
        $response = $this->get(route('members.index', ['format' => 'text']));
        $response->assertStatus(200);
    }

    public function test_store_missing_fields_json_format()
    {
        $response = $this->post(route('members.store'));
        $response->assertStatus(400)->assertJson([
            "first_name" => [
                "The first name field is required."
            ],
            "last_name" => [
                "The last name field is required."
            ],
            "gender" => [
                "The gender field is required."
            ],
            "date_of_birthday" => [
                "The date of birthday field is required."
            ],
            "email" => [
                "The email field is required."
            ]
        ]);
    }

    public function test_store()
    {
        $first_name = Str::random(4);
        $last_name = Str::random(4);
        $email = "{$first_name}.{$last_name}@linecorp.com";
        $data = [
            "first_name" => $first_name,
            "last_name" => $last_name,
            "gender" => Member::Genders[array_rand(Member::Genders)],
            "date_of_birthday" => Date('Y-m-d'),
            "email" => $email
        ];

        $response = $this->post(route('members.store'), $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas(Member::class, $data);
    }

    public function test_store_duplicate_email_json_format()
    {
        $first_name = Str::random(4);
        $last_name = Str::random(4);
        $email = "{$first_name}.{$last_name}@linecorp.com";
        $data = [
            "first_name" => $first_name,
            "last_name" => $last_name,
            "gender" => Member::Genders[array_rand(Member::Genders)],
            "date_of_birthday" => Date('Y-m-d'),
            "email" => $email
        ];

        $this->post(route('members.store'), $data);
        $response = $this->post(route('members.store'), $data);
        $response->assertStatus(400)->assertJson([
            "email" => [
                "The email has already been taken."
            ]
        ]);
    }

    public function test_destroy()
    {
        $this->seed();
        $member = Member::first();
        $response = $this->delete(route('members.destroy', [$member->id]));
        $response->assertStatus(200)->assertJson(['data' => true]);
        $this->assertDatabaseMissing(Member::class, $member->toArray());
    }

    public function test_destroy_not_found()
    {
        $this->seed();
        $response = $this->delete(route('members.destroy', [-1]));
        $response->assertStatus(404)->assertJson(['message' => "The member not found."]);
    }
}
