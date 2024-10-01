<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "first_name"=>'required|regex:/^[A-Za-z ]+$/',
            "last_name"=>'required|regex:/^[A-Za-z ]+$/',
            'email' => 'required|email:rfc,dns',
            'picture'=>'file|mimes:jpg,bmp,png',
            'user'=>'exists:users,id'
        ];
    }
}
