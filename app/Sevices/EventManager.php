<?php

namespace App\Services;

use App\Services\EventHandlers\LoginAuction;
use App\Services\EventHandlers\LogoutAuction;
use Demo\Models\User;
use RuntimeException;

class EventManager
{
    protected static array $eventHandlers = [
        1 => LoginAuction::class,
        2 => LogoutAuction::class,
    ];
    public function __construct(
        protected User $user,
        protected int $event,
    ) {}

    public static function make(User $user, int $event): static
    {
        return app(static::class, compact('user', 'event'));
    }

    public function commit(array $data = []): void
    {
        if (!isset(static::$eventHandlers[$this->event])) {
            throw new RuntimeException('Event not found');
        }

        static::$eventHandlers[$this->event]::make($this->user, $data)->handle();
    }
}
