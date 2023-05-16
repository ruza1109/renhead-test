<?php

namespace App\Enums;

enum ApprovalStatus: string
{
    case APPROVED = 'APPROVED';
    case DISAPPROVED = 'DISAPPROVED';
}
