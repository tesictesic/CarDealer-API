<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminInsertUpdateServiceRequest extends FormRequest
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
            "service_packet_id"=>'required|exists:service_packs,id',
            'name'=>'required|min:2',
            'description'=>'required|min:10|max:500',
            'icon'=>'file|mimes:jpg,bmp,png',
            'price'=>'required'
        ];
    }
}
