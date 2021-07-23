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

    public function elderPictureMessage()
    {
        [$year, $month, $day] = explode('-', date('Y-m-d'));
        $members = $this->memberRepository
            ->whereBirthday($month, $day)
            ->whereYear('date_of_birthday', '<=', $year - 49)
            ->get();

        if ($members->count() === 0) {
            return Response('No Results.');
        }

        $output = '';
        foreach ($members as $member) {
            $output .= "Subject: Happy birthday!\nHappy birthday, dear `{$member->first_name}`!\n";
            $output .= "<img src='https://picsum.photos/200' alt='Greeting Elder Picture'>";
        }

        return Response($output);
    }
}
