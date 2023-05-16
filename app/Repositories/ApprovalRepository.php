<?php

namespace App\Repositories;

use App\Enums\ApprovalStatus;
use App\Models\Approval;

class ApprovalRepository
{
    public function approveByJobAndUserId(int $jobId, int $userId)
    {
        return Approval::where('job_id', $jobId)
            ->where('user_id', $userId)
            ->update([
                'status' => ApprovalStatus::APPROVED->value
            ]);
    }
}
