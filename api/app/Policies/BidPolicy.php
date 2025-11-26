<?php

declare(strict_types=1);

namespace App\Api\Policies;

use Demo\Models\User;
use App\Models\Bid;
use Demo\Api\Policies\Concerns\Policy as BasePolicy;

class BidPolicy extends BasePolicy
{
    public function view(?User $user, Bid $bid): bool
    {
        return true;
    }

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }
}
