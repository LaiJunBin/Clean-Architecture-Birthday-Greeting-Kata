<?php

namespace App\Repositories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class MemberRepository
{
    protected $member;

    public function __construct(Member $member = null)
    {
        $this->member = $member;
    }

    public function whereBirthday($month, $day): Collection
    {
        return Member::get()->filter(function ($member) use ($month, $day) {
            [$m, $d] = explode('-', date('m-d', strtotime($member->date_of_birthday)));
            return $month == $m && $day == $d;
        });
    }
}
