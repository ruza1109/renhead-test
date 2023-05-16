<?php

namespace App\Http\Requests;

class StoreProfessorRequest extends StoreUserRequest
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
        $rules = parent::rules();

        return array_merge($rules, [
            'total_available_hours' => 'required|numeric',
            'payroll_per_hour' => 'required|numeric',
            'total_projects' => 'required|numeric',
            'office_number' => 'required|numeric',
        ]);
    }
}