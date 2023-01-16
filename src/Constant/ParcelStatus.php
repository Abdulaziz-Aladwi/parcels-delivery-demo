<?php

namespace App\Constant;

final class ParcelStatus
{
    const TYPE_PENDING = 1;
    const TYPE_PENDING_LABEL = 'pending';

    const TYPE_PICKED_UP = 2;
    const TYPE_PICKED_UP_LABEL = 'picked_up';

    public static function getParcelStatus(): array
    {
        return [
            self::TYPE_PENDING => self::TYPE_PENDING_LABEL,
            self::TYPE_PICKED_UP => self::TYPE_PICKED_UP_LABEL,
        ];
    }

    public static function getLabel(int $status): ?string
    {
        return self::getParcelStatus()[$status] ?? 'Not Defined';
    }

}

