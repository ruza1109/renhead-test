<?php

namespace App\Enums;

use App\Traits\EnumValues;

enum UserType: string
{
    use EnumValues;

    case APPROVER = 'APPROVER';
    case NON_APPROVER = 'NON_APPROVER';
}
