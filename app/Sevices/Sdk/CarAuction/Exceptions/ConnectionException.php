<?php

namespace App\Services\Sdk\CarAuction\Exceptions;

use RuntimeException;
use Throwable;

class ConnectionException extends RuntimeException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        $message = 'Something went wrong with auction api connection';

        parent::__construct($message, $code, $previous);
    }
}

{

}
