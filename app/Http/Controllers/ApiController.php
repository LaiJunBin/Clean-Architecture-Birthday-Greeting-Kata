<?php

namespace App\Http\Controllers;


use App\Repositories\MemberRepository;

class ApiController extends Controller
{
    protected $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function simpleMessage()
    {
        [$month, $day] = explode('-', date('m-d'));
        $members = $this->memberRepository->whereBirthday($month, $day)->get();
        if ($members->count() === 0) {
            return Response('No results.');
        }

        $output = '';
        foreach ($members as $member) {
            $output .= "Subject: Happy birthday!\nHappy birthday, dear {$member->first_name}!\n";
        }

        return Response($output);
    }
}
