<?php

namespace App\Constant;

final class UserTypes
{
    const TYPE_SENDER = 1;
    const TYPE_SENDER_LABEL = 'Sender';

    const TYPE_BIKER = 2;
    const TYPE_BIKER_LABEL = 'Biker';

    public static function getUserTypes(): array
    {
        return [
            self::TYPE_SENDER_LABEL => self::TYPE_SENDER,
            self::TYPE_BIKER_LABEL => self::TYPE_BIKER,
        ];
    }

}

