<?php

namespace App\Http\Controllers;

use App\Exceptions\UserMustBeApproverException;
use App\Models\Job;
use App\Services\ApprovalService;
use Illuminate\Http\JsonResponse;

class ApprovalController extends Controller
{
    public function __construct(
        private readonly ApprovalService $approvalService,
    ) {}

    /**
     * @throws UserMustBeApproverException
     */
    public function approve(Job $job): JsonResponse
    {
        $this->approvalService->approve($job);

        return response()->json(status: 204);
    }
}
