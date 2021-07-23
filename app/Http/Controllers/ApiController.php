<?php

namespace App\Http\Controllers;

use App\Models\Member;

use App\Repositories\MemberRepository;

class ApiController extends Controller
{
    protected $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function tailorMadeMessage()
    {
        [$month, $day] = explode('-', date('m-d'));

        $tailor_messages = [
            Member::Male => "We offer special discount 20% off for the following items:\nWhite Wine, iPhone X\n",
            Member::Female => "We offer special discount 50% off for the following items:\nCosmetic, LV Handbags\n"
        ];

        $output = '';
        foreach (Member::Genders as $gender) {
            $members = $this->memberRepository
                ->whereBirthday($month, $day)
                ->where('gender', $gender)->get();

            $output .= "{$gender}\n";

            if ($members->count() === 0) {
                $output .= "No results.\n";
                continue;
            }

            foreach ($members as $member) {
                $output .= "Subject: Happy birthday!\nHappy birthday, dear {$member->first_name}!\n{$tailor_messages[$gender]}";
            }
            $output .= "\n";
        }
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
