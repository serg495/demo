<?php

declare(strict_types=1);

namespace App\Services\EventHandlers;

use Demo\Models\User;

abstract class BaseEventHandler
{
    public function __construct(
        protected User $user,
        protected array $data = []
    ) {}

    public static function make(User $user, array $data = []): static
    {
        return app(static::class, compact('user', 'data'));
    }

    abstract public function handle(): bool;
}
