<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Bid;
use App\Models\LotCheck;
use App\Services\Sdk\CarAuction\CarAuctionSdk;
use Throwable;

class BidService
{
    public function __construct(
        protected Bid $bid,
    ) {}

    public static function make(Bid $bid): static
    {
        return app(static::class, compact('bid'));
    }

    public function attachVinIfNotExists(): static
    {
        if ($this->bid->vin) {
            return $this;
        }

        $vin = CarAuctionSdk::make()->transport()
            ->findVin($this->bid->lot_number, $this->bid->auction);

        $this->bid->update(['vin' => $vin]);

        $this->bid->refresh();

        return $this;
    }

    /**
     * @throws Throwable
     */
    public function addLotToCheckListIfNotExists(): static
    {
        $vin = $this->bid->vin;

        throw_if(! $vin, 'VIN is required to add to check list');

        if (! LotCheck::query()->where('vin', $vin)->exists()) {
            LotCheck::query()->create([
                'vin' => $vin,
                'auction' => $this->bid->auction,
                'auction_date' => now()->startOfDay(),
            ]);
        }

        return $this;
    }
}
