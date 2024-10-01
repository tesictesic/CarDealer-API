<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminInsertUpdateModelRequest extends FormRequest
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
            'model_name'=>[
                'required',
                Rule::unique('brands','name')->where('parent_id','!=',null)
            ],
            'brand_id'=>[
                'required',
                Rule::exists('brands','id')->whereNull('parent_id')
            ]
        ];
    }
}
