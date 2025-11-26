<?php

declare(strict_types=1);

namespace App\Api\Providers;

use App\Api\Policies\BidPolicy;
use App\Models\Bid;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class BidEntityApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Bid::class, BidPolicy::class);
    }
}
