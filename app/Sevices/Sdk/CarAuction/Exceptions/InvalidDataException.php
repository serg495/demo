<?php

namespace App\Services\Sdk\CarAuction\Exceptions;

use RuntimeException;
use Throwable;

class InvalidDataException extends RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $message = $message ?: 'Invalid input data';

        parent::__construct($message, $code, $previous);
    }
}
