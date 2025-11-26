<?php

namespace App\Services\Sdk\CarAuction;

use App\Services\Sdk\CarAuction\Exceptions\AuthenticationException;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

class Auth
{
    public function __construct(
        protected string $email,
        protected string $password,
        protected Client $client,
    ) {}

    public function accessToken(bool $forceReset = false): ?string
    {
        if (! $forceReset && ($token = $this->cachedAccessToken())) {
            return $token;
        }

        try {
            $token = $this->authenticate();
        } catch (RuntimeException) {
            return null;
        }

        return $this->cacheAccessToken($token);
    }

    protected function authenticate(): string
    {
        $response = $this->client->post('api/v1/login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if (! $response->successful() || ! $response->json('token')) {
            throw new AuthenticationException($response);
        }

        return $response->json('token');
    }

    protected function cacheAccessToken(string $token): string
    {
        Cache::put(
            config('auction_api.auth.token_cache_key'),
            $token,
            config('auction_api.auth.token_cache_ttl'),
        );

        return $token;
    }

    protected function cachedAccessToken(): ?string
    {
        return Cache::get(config('auction_api.auth.token_cache_key'));
    }
}
