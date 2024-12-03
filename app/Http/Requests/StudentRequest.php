<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'matricule' => 'required|string|max:255',
            'department_id' => 'required|integer',
            'program_id' => 'required|integer',
            'cycle_id' => 'required|integer',
            'level' => 'required|string|max:255',
            
        ];
    }
}
