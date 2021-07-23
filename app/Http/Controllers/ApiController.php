<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function simpleMessageButDifferentFormat(Request $request)
    {
        $format = $request->get('format', 'text');
        [$month, $day] = explode('-', date('m-d'));
        return $this->apiService->simpleMessageForBirthDay($month, $day, $format);
    }
}
