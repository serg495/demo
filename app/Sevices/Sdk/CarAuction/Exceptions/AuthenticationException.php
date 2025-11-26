<?php

namespace App\Services\Sdk\CarAuction\Exceptions;

use Illuminate\Http\Client\Response;
use RuntimeException;
use Throwable;

class AuthenticationException extends RuntimeException
{
    protected readonly ?Response $response;

    public function __construct(
        Response $response = null,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);

        $this->response = $response;
    }
}
