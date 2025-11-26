<?php

declare(strict_types=1);

use Demo\Enums\Concerns\Enum;

class Auction implements Enum
{
    use ExtendableEnum;

    public const COPART = 'copart';

    public const IAAI = 'iaai';

    public static string $translationPath = 'list_titles.bid_auction';
}
