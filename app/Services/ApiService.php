<?php

namespace App\Services;

use App\Repositories\MemberRepository;
use App\Responses\TextResponse;
use App\Responses\XMLResponse;

class ApiService
{
    protected $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public static function response($data = [], $format = "text", $status = 200, array $headers = [])
    {
        switch ($format) {
            case 'json':
                return Response()->json($data, $status, $headers);
            case 'xml':
                return new XMLResponse($data, $status, $headers);
            default:
                return new TextResponse($data, $status, $headers);
        }
    }

    public function simpleMessageForBirthDay($month, $day, $format)
    {
        $members = $this->memberRepository->whereBirthday($month, $day)->get();
        if ($members->count() === 0) {
            return self::response('No Results.', $format);
        }

        $data = [];
        foreach ($members as $member) {
            $data[] = [
                'title' => 'Subject: Happy birthday!',
                'content' => "Happy birthday, dear {$member->first_name}!",
            ];
        }

        return self::response($data, $format);
    }
}
