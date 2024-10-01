<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminInsertUpdateCarPriceRequest extends FormRequest
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
            "vehicle_id"=>'required|exists:vehicles,id',
            'price'=>'required',
            'date_of' => [
                'required',
                'date',
                'before_or_equal:' . now()->format('Y-m-d'),
            ],
            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_of',
            ],

        ];
    }
}
