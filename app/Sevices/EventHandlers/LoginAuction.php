<?php

declare(strict_types=1);

namespace App\Services\EventHandlers;

use App\Models\Activity;
use Illuminate\Support\Arr;

class LoginAuction extends BaseEventHandler
{
    public function handle(): bool
    {
        Activity::query()->create([
            'user_id' => $this->user->id,
            'auction' => Arr::get($this->data, 'auction'),
        ]);

        return true;
    }
}
