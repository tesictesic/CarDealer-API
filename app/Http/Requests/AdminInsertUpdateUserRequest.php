<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminInsertUpdateUserRequest extends FormRequest
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
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password'=>["required",Password::min(8)->mixedCase()->symbols()],
            'picture'=>'file|mimes:jpg,bmp,png',
            'role_id'=>'required|exists:roles,id'
        ];
    }
public function messages()
{
    return[
        "password"=>"Your password require 8 characters at least one uppercase one lowercase one symbol"
    ];
}
}
