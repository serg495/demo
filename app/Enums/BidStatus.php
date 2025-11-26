<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Demo\Enums\Concerns\Enum;

class BidStatus implements Enum
{
    public const IN_PROGRESS = 'in_progress';

    public const WON = 'won';

    public const LOST = 'lost';

    public static string $translationPath = 'list_titles.bid_status';

    protected static array $allowedStatusMapping = [
        self::IN_PROGRESS => [self::IN_PROGRESS, self::WON, self::LOST],
        self::WON => [self::WON, self::LOST],
        self::LOST => [self::WON, self::LOST],
    ];

    public static function allowedStatusesLabels(string $status): array
    {
        $labels = self::labels();

        foreach ($labels as $key => $label) {
            if (! in_array($key, self::allowedStatuses($status))) {
                unset($labels[$key]);
            }
        }

        return $labels;
    }

    public static function allowedStatuses(string $status): array
    {
        return Arr::get(self::$allowedStatusMapping, $status);
    }
}
