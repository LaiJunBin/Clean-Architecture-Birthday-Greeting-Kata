<?php

namespace App\Responses;

use \Illuminate\Http\Response;

class TextResponse extends Response
{
    public function __construct($data = '', $status = 200, array $headers = [])
    {
        if (is_array($data)) {
            $content = '';
            array_walk_recursive($data, function ($d) use (&$content) {
                $content .= $d . PHP_EOL;
            });
        } else {
            $content = $data;
        }

        parent::__construct($content, $status, $headers);
    }
}
