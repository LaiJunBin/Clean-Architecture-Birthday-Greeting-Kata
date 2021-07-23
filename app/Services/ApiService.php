<?php

namespace App\Services;

use App\Repositories\MemberRepository;
use App\Responses\TextResponse;
use App\Responses\XMLResponse;

class ApiService
{
    protected $memberRepository;

    const FormatMapping = [
        'text/plain' => 'text',
        'application/json' => 'json',
        'application/xml' => 'xml'
    ];

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    private static function getFormat()
    {
        $accept = Request()->header('accept');
        return self::FormatMapping[$accept] ?? null;
    }

    public static function response($data = [], $format = 'text', $status = 200, array $headers = [])
    {
        $format = self::getFormat() ?? $format;
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
            return self::response('No results.', $format);
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
