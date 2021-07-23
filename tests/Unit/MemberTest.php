<?php

namespace Tests\Unit;

use App\Models\Member;

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
    public function test_getMembersByBirthdayAndAge()
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
  
    public function test_getMembersByBirthdayAndGenderFind()
    {
        $this->seed();
        $male_members = $this->memberRepository->whereBirthday(8, 8)->where('gender', Member::Male)->get();
        $female_members = $this->memberRepository->whereBirthday(8, 8)->where('gender', Member::Female)->get();
        $this->assertCount(1, $male_members);
        $this->assertCount(1, $female_members);

    }

    public function test_getMembersByBirthdayAndGenderNotFound()
    {
        $this->seed();
        $male_members = $this->memberRepository->whereBirthday(8, 9)->where('gender', Member::Male)->get();
        $female_members = $this->memberRepository->whereBirthday(8, 9)->where('gender', Member::Female)->get();
        $this->assertCount(0, $male_members);
        $this->assertCount(0, $female_members);
    }
  
    public function test_getMembersByBirthDay()
    {
        $this->seed();
        $members = $this->memberRepository->whereBirthday(8, 8)->get();
        $this->assertCount(2, $members);
        $members = $this->memberRepository->whereBirthday(8, 9)->get();
        $this->assertCount(0, $members);
    }
}
