<?php

namespace App\Services\Sdk\CarAuction;

use App\Services\Sdk\CarAuction\Services\Transport;
use Demo\Services\HttpClient\Sdk;
use Demo\Services\HttpClient\SdkService;

/**
 * @method Transport transport()
 */
class CarAuctionSdk extends Sdk
{
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __call($name, $arguments): SdkService
    {
        return $this->loadService($name);
    }
}
