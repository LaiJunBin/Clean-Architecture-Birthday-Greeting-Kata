<?php

namespace App\Responses;

use \Illuminate\Http\Response;

class XMLResponse extends Response
{
    public function __construct($data = [], $status = 200, array $headers = [])
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root/>');

        if (!is_array($data)) {
            $xml[0] = $data;
        } else {
            $this->array2xml($xml, $data);
        }

        $headers['Content-Type'] = 'application/xml';
        parent::__construct($xml->asXML(), $status, $headers);
    }

    private function array2xml(&$xml, $array)
    {
        if (is_numeric($array) || is_string($array)) {
            $xml[0] = $array;
            return;
        }

        foreach ($array as $key => $value) {
            if (is_numeric($key)) {
                $this->array2xml($xml->wrapper[$key], $value);
            } else if (is_array($value)) {
                $this->array2xml($xml->$key[count($xml->$key)], $value);
            } else {
                $xml->$key = $value;
            }
        }
    }
}
