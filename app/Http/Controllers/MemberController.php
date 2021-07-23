<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use App\Services\ApiService;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $format = $request->get('format', 'json');
        $members = Member::get()->toArray();
        return ApiService::response(['data' => $members], $format);
    }

    public function store(MemberRequest $request)
    {
        $format = $request->get('format', 'json');
        $validated = $request->validated();
        $member = Member::create($validated);
        return ApiService::response(['id' => $member->id], $format);
    }

    public function destroy(Request $request, $id)
    {
        $format = $request->get('format', 'json');
        $member = Member::find($id);
        if (!$member) {
            return ApiService::response(['message' => 'The member not found.'], $format, 404);
        }

        $member->delete();
        return ApiService::response(['data' => true], $format);
    }
}
