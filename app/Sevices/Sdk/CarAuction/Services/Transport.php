<?php

namespace App\Services\Sdk\CarAuction\Services;

use App\Services\Sdk\CarAuction\Resources\TransportResource;
use Illuminate\Support\Arr;
use Demo\Services\HttpClient\SdkService;

class Transport extends SdkService
{
    public function findByVin(string $vin): TransportResource
    {
        $response = $this->client->post('api/v1/get-car-vin', [
            'vin' => $vin,
            'history' => true,
        ]);

        return TransportResource::make(Arr::last($response->json('data')));
    }

    public function findVin(string $lot, string $source): string
    {
        $response = $this->client->post('api/v1/find-vin', [
            'number' => $lot,
            'source' => $source,
        ]);

        return $response->json('data.vin');
    }

}
