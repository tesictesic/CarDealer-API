<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'picture'=>'file|mimes:jpg,bmp,png',
            'password'=>["required",Password::min(8)->mixedCase()->symbols()],

        ];
    }
    public function messages()
    {
        return[
            "first_name.regex"=>"Your fist_name is not good. Example: Djordje",
            "last_name.regex"=>"Your last_name is not good. Example: Tesic ",
            "password"=>"Your password require 8 characters at least one uppercase one lowercase one symbol",
            "re-password"=>"Your re password is not same as password",
            "email.unique"=>"That password has already in database"
        ];
    }
}
