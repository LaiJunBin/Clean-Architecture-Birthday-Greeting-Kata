<?php

namespace App\Http\Requests;

use App\Models\Member;
use App\Services\ApiService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => [
                'required',
                Rule::in(Member::Genders)
            ],
            'date_of_birthday' => 'required|date',
            'email' => 'required|unique:members|max:100',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $format = $this->get('format', 'json');
        throw new HttpResponseException(ApiService::response($validator->getMessageBag()->getMessages(), $format, 400));
    }
}
