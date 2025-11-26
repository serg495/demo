<?php

declare(strict_types=1);

namespace App\Services\ImageParser;

use App\Enums\Auction;
use RuntimeException;

class ImageParserFactory
{
    protected static array $parsers = [
        Auction::IAAI => IaaiImageDataParser::class,
        Auction::COPART => CopartImageDataParser::class,
    ];

    public static function parser(string $auction, string $filePath): BaseImageDataParser
    {
        if (! isset(static::$parsers[$auction])) {
            throw new RuntimeException(sprintf('Image parser for auction "%s" not found.', $auction));
        }

        return static::$parsers[$auction]::make($filePath);
    }
}
