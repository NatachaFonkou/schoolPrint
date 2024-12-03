<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CycleRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'program_id' => 'required|integer',
            'department_id' => 'required|integer',
            'start_year' => 'required|integer',
            'end_year' => 'required|integer',
            'students' => 'required|integer',
            'status' => 'required|string|max:255',
        ];
    }
}
