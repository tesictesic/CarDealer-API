<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminStoreNameColumnRequest extends FormRequest
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
        $tabela=$this->input('table');
       $string="";
        $tabela=='colors'?$string="$tabela,color_name":$string="$tabela,name";
        $kolona="";
        $tabela=='colors'?$kolona='color_name':$kolona='name';
        return [
            $kolona=>"required|unique:$string|min:2"
        ];
    }
    public function messages()
    {
        $tabela=$this->input('table');
        $kolona="";
        $tabela=='colors'?$kolona='color_name':$kolona='name';
        return[
            $kolona.'.unique'=>"This value has already in $tabela"
        ];
    }
}
