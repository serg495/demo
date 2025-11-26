<?php

namespace App\Services\Sdk\CarAuction;

use App\Services\Sdk\CarAuction\Exceptions\ConnectionException;
use App\Services\Sdk\CarAuction\Exceptions\InvalidDataException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Demo\Module\Logs\Services\HttpLogger\HttpClientOutboundWriter;
use Demo\Services\HttpClient\HttpClient;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Throwable;

class Client extends HttpClient
{
    protected ?string $token = null;

    public function __construct(
        protected string $baseUrl,
    ) {}

    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    public function withToken(?string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function token(): string
    {
        return $this->token;
    }

    /**
     * @throws Throwable
     */
    protected function request(
        string $method,
        string $uri,
        array $data = [],
        array $headers = [],
        array $attachments = [],
    ): Response {
        $request = Http::baseUrl($this->baseUrl)
            ->withHeaders($headers)
            ->withToken($this->token)
            ->asJson();

        $response = $this->send($request, $method, $uri, $data);

        if ($response->failed()) {
            throw match ($response->status()) {
                HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR => new ConnectionException(),
                HttpFoundationResponse::HTTP_BAD_REQUEST => new InvalidDataException(),
                default => new RuntimeException("Unable to request {$method} {$uri}. Status: {$response->status()}"),
            };
        }

        return $response;
    }
}
