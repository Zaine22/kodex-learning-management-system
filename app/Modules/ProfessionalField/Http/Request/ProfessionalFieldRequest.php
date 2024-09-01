<?php

namespace App\Modules\ProfessionalField\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class ProfessionalFieldRequest extends FormRequest{

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'        => 'required|string|min:1',
            'description' => 'required|string',
        ];
    }
}
