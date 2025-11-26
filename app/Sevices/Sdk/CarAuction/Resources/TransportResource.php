<?php

declare(strict_types=1);

namespace App\Services\Sdk\CarAuction\Resources;

use Carbon\CarbonInterface;
use Illuminate\Support\Arr;

class TransportResource extends BaseResource
{
    public string $vin;

    public string $year;

    public array $model;

    public bool $has_keys;

    public string $state;

    public string $city;

    public ?string $engine_fuel;

    public ?CarbonInterface $started_at = null;

    public ?CarbonInterface $sold_at = null;

    protected array $casts = [
        'has_keys' => 'boolean',
        'started_at' => 'datetime',
        'sold_at' => 'datetime',
    ];

    public function brandAndModel(): string
    {
        $brand = Arr::get($this->model, 'brand.name' );
        $model = Arr::get($this->model, 'clean_model.name');

        return "{$brand} {$model}";
    }

    public function location(): string
    {
        return "{$this->state} - {$this->city}";
    }

    public function finalBid(): int
    {
        $history = json_decode(Arr::get($this->data, 'lot_bid_histories'), true);
        $maxBid = (int) collect($history)->max('bid');

        return $maxBid * 100;
    }
}
