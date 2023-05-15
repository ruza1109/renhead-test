<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email'         => 'sometimes|string|unique:users,email',
            'first_name'    => 'sometimes|string',
            'last_name'     => 'sometimes|string',
            'type'          => [
                'sometimes',
                'string',
                Rule::in(UserType::getValues())
            ],
            'password'      => 'sometimes|string',
        ];
    }
}
