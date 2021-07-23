<?php

namespace Tests\Unit;

use App\Repositories\MemberRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    protected $memberRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->memberRepository = new MemberRepository();
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_getMembersByBirthDay()
    {
        $this->seed();
        $members = $this->memberRepository->whereBirthday(8, 8)->get();
        $this->assertCount(2, $members);
        $members = $this->memberRepository->whereBirthday(8, 9)->get();
        $this->assertCount(0, $members);
    }
}
