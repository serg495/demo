<?php

declare(strict_types=1);

namespace App\Services\ImageParser;

use bug\Bug;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Demo\Component\Supports\Classes\StaticMake;

class Base64ToImageDecoder
{
    protected ?string $filePath;

    public function __construct(
        protected string $imageString,
        protected ?string $path = null,
        protected ?string $filename = null,
    ) {
        $this->path = $path ?: 'app/temp';
        $this->filename = $filename ?: Str::random();
    }

    public static function make(string $imageString, ?string $storagePath = null, ?string $filename = null): static
    {
        return app(static::class, compact('imageString', 'storagePath', 'filename'));
    }

    public function decode(): ?string
    {
        $base64String = substr($this->imageString, strpos($this->imageString, ',') + 1);
        $base64String = str_replace(' ', '+', $base64String);
        $imageData = base64_decode($base64String);

        if ($imageData === false) {
            return null;
        }

        $filePath = rtrim($this->path, '/') . '/' . $this->filename . '.' . $this->extension();

        Storage::put($filePath, $imageData);

        $this->filePath = $filePath;

        return $this->filePath;
    }

    protected function extension(): string
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $this->imageString, $type)) {
            return strtolower($type[1]);
        }

        return 'png';
    }

    public function deleteImage(): void
    {
        if ($this->filePath) {
            Storage::delete($this->filePath);
        }
    }
}
