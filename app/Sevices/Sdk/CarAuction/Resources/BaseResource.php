<?php

declare(strict_types=1);

namespace App\Services\Sdk\CarAuction\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Client\Response;
use Demo\Services\Settings\Concerns\AttributesCasting;
use stdClass;

abstract class BaseResource implements Arrayable
{
    use AttributesCasting;

    protected ?string $dataKey = 'data';

    protected array $casts = [];

    protected array $data;

    public function __construct(iterable|stdClass|Response $data)
    {
        if ($data instanceof Response) {
            $data = $data->json($this->dataKey);
        }

        $this->hydrate($data);

        $this->data = $data;
    }

    public static function make(iterable|stdClass|Response $data): static
    {
        return app(static::class, compact('data'));
    }

    protected function hydrate(array $data): void
    {
        foreach ($data as $attribute => $value) {
            if (is_array($value)) {
                $this->hydrate($value);
            }

            try {
                if (! property_exists($this, $attribute)) {
                    continue;
                }
            } catch (\Throwable) {
                continue;
            }

            if (isset($this->casts[$attribute])) {
                $this->{$attribute} = $this->castAttribute($attribute, $value);
            } else {
                $this->{$attribute} = $value;
            }
        }
    }

    public function getCasts(): array
    {
        return $this->casts;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
