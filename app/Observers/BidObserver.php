<?php

declare(strict_types=1);

namespace Observers;

use App\Models\Bid;
use App\Services\BidService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class BidObserver implements ShouldQueue
{
    /**
     * @throws Throwable
     */
    public function created(Bid $bid): void
    {
        BidService::make($bid)
            ->attachVinIfNotExists()
            ->addLotToCheckListIfNotExists();
    }
}
