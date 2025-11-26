<?php

declare(strict_types=1);

namespace App\Api\Providers;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * @var array<string>
     */
    protected $providers = [
        BidEntityApiServiceProvider::class,
    ];
}
