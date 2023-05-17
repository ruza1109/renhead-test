<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class UserMustBeApproverException extends \Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => 'User must be approver in order to approve.'
        ], 403);
    }
}
