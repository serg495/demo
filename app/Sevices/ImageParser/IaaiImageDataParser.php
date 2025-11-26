<?php

declare(strict_types=1);

namespace App\Services\ImageParser;

class IaaiImageDataParser extends BaseImageDataParser
{
    public function getBid(): int
    {
        preg_match('/CURRENT HIGH BID\s*\$([\d,]+)/', $this->imageData, $matches);

        return (int) (str_replace([',', ' '], '', $matches[1])) * 100;
    }

    public function getLotNumber(): string
    {
        preg_match('/Stock\s*#:\s*(\d+)/', $this->imageData, $matches);

        return $matches[1];
    }
}
