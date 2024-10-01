<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminInsertUpdateVehicleRequest extends FormRequest
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
            'horsepower'=>'required|min:1',
            'seats'=>'required|min:1',
            'description'=>'required|min:10|max:500',
            'year' => 'required|date_format:Y|before_or_equal:'.now()->year,
            'image'=>'file|mimes:jpg,bmp,png',
            'brand_id' => [
                'required',
                Rule::exists('brands', 'id')->whereNull('parent_id'),
            ],
            'model_id' => [
                'required',
                Rule::exists('brands', 'id')->where('parent_id', '!=', null),
            ],
            'car_body_id'=>'required|exists:car_body,id',
            'fuel_id'=>'required|exists:fuels,id',
            'color_id'=>'required|exists:colors,id',
            'price'=>'required'


        ];
    }
}
