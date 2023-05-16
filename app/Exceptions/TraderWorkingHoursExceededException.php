<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class TraderWorkingHoursExceededException extends \Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => 'The total hours for this job exceed the working hours for this trader.'
        ], 422);
    }
}
