<?php

declare(strict_types=1);

use App\Models\Bid;
use App\Observers\BidObserver;
use Illuminate\Support\ServiceProvider;

class BidEntityServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Bid::observe(BidObserver::class);
    }
}
