<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class ProfessorTotalAvailableHoursExceededException extends \Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => 'The total hours for this job exceed the available hours for this professor.'
        ], 422);
    }
}
