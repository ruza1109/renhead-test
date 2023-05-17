<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class EmployeeAlreadyHasJobForGivenDateException extends \Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => 'Employee already has job for given date.'
        ], 422);
    }
}
