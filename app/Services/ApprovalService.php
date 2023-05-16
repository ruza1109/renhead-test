<?php

namespace App\Services;

use App\Exceptions\UserMustBeApproverException;
use App\Models\Job;
use App\Repositories\ApprovalRepository;
use Illuminate\Support\Facades\Auth;

class ApprovalService
{
    public function __construct(
        private readonly ApprovalRepository $approvalRepository,
    ) {}

    /**
     * @throws UserMustBeApproverException
     */
    public function approve(Job $job): void
    {
        $user = Auth::user();

        if (!$user->isApprover()) {
            throw new UserMustBeApproverException();
        }

        $this->approvalRepository->approveByJobAndUserId(
            $job->id,
            $user->id
        );
    }
}
