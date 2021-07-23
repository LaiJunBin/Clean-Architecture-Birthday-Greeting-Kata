<?php

namespace Tests\Unit;

use App\Repositories\MemberRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use DatabaseMigrations;

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
        $members = $this->memberRepository->whereBirthday(8, 8);
        $this->assertCount(2, $members);
        $members = $this->memberRepository->whereBirthday(8, 9);
        $this->assertCount(0, $members);
    }
}
