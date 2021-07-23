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
    public function test_example()
    {
        $this->seed();
        $year = 2021;
        $members = $this->memberRepository->whereBirthday(12, 22)->whereYear('date_of_birthday', '<=', $year - 49)->get();
        $this->assertCount(1, $members);
        $members = $this->memberRepository->whereBirthday(12, 22)->whereYear('date_of_birthday', '<=', $year - 72)->get();
        $this->assertCount(0, $members);
        $members = $this->memberRepository->whereBirthday(8, 8)->whereYear('date_of_birthday', '<=', $year - 49)->get();
        $this->assertCount(0, $members);
    }
}
