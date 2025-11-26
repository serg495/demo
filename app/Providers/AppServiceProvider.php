<?php

declare(strict_types=1);

use App\Services\Sdk\CarAuction\Auth;
use App\Services\Sdk\CarAuction\CarAuctionSdk;
use App\Services\Sdk\CarAuction\Client;
use App\Services\Sdk\CarAuction\Services\Transport;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array<string>
     */
    protected $providers = [
        BidEntityServiceProvider::class,
    ];

    public function boot(): void
    {
        $this->registerAuctionSdk();
    }

    protected function registerAuctionSdk(): void
    {
        $this->app->singleton(Client::class, function () {
            return new Client(config('auction_api.base_url'));
        });

        $this->app->singleton(Auth::class, function () {
            return new Auth(
                config('auction_api.email'),
                config('auction_api.password'),
                $this->app->get(Client::class),
            );
        });

        $this->app->singleton(Transport::class, function () {
            return new Transport($this->app->get(Client::class));
        });

        $this->app->singleton(CarAuctionSdk::class, function () {
            $token = $this->app->get(Auth::class)->accessToken();
            $client = $this->app->get(Client::class);

            return new CarAuctionSdk($client->withToken($token));
        });
    }
}
