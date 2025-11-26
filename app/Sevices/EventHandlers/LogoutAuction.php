<?php

declare(strict_types=1);

namespace App\Services\EventHandlers;

use App\Models\Activity;
use Illuminate\Support\Arr;

class LogoutAuction extends BaseEventHandler
{
    public function handle(): bool
    {
        Activity::query()
            ->where('user_id', $this->user->id)
            ->where('auction', Arr::get($this->data, 'auction'))
            ->update(['ended_at' => now()]);

        return true;
    }
}
