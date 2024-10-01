<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'name'=>'required|regex:/^([A-ZŠĐŽĆČ][a-zšđžćč]{2,15})\s([A-ZŠĐŽĆČ][a-zšđžćč]{2,15}){0,2}$/',
            'email'=>'required|email:rfc,dns',
            'subject'=>'required',
            'message'=>'required|min:5'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'name.regex'=>'Your name is not in good format. Example:Djordje Tesic',
            'email.required' => 'A message is required',
            'email.regex'=>'Your email is not in good format. Example:djordjetesic@gmail.com',
            'subject.required'=>'A name is required',
            'messages.min'=>'Your have to fill in message field and that have to be longer than five characters'
        ];
    }
}
