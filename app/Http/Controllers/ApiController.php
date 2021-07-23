<?php

namespace App\Http\Controllers;

use App\Repositories\MemberRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function simpleMessageButDatabaseChanges()
    {
        [$month, $day] = explode('-', date('m-d'));
        $members = $this->memberRepository->whereBirthday($month, $day);
        if ($members->count() === 0) {
            return Response('No Results.');
        }

        $output = '';
        foreach ($members as $member) {
            $output .= "Subject: Happy birthday!\nHappy birthday, dear {$member->last_name}!\n";
        }
        return Response($output);
    }
}
