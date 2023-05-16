<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfessorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'total_available_hours' => 'sometimes|numeric',
            'payroll_per_hour' => 'sometimes|numeric',
            'total_projects' => 'sometimes|numeric',
            'office_number' => 'sometimes|numeric',
        ];
    }
}
