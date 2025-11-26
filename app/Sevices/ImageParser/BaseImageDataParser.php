<?php

declare(strict_types=1);

namespace App\Services\ImageParser;

use thiagoalessio\TesseractOCR\TesseractOCR;

abstract class BaseImageDataParser
{
    protected ?string $imageData;

    public function __construct(string $filePath)
    {
        $this->imageData = app(TesseractOCR::class, ['image' => $filePath])->run();
    }

    public static function make(string $filePath): static
    {
        return app(static::class, compact('filePath'));
    }

    abstract public function getBid(): int;

    abstract public function getLotNumber(): string;
}
