<?php

namespace App\Repositories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;

class MemberRepository
{
    protected $member;

    public function __construct(Member $member = null)
    {
        $this->member = $member;
    }

    public function whereBirthday($month, $day): Builder
    {
        return Member::whereMonth('date_of_birthday', $month)->whereDay('date_of_birthday', $day);
    }
}
