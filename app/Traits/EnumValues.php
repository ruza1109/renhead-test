<?php

namespace App\Traits;

trait EnumValues
{
    public static function getValues(): array
    {
        return array_map(
            fn($userType) =>
                $userType->value,
            self::cases()
        );
    }
}
