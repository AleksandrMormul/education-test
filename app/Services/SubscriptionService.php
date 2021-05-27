<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;

/**
 * Class SubscriptionService
 * @package App\Services
 */
class SubscriptionService
{

    /**
     * @param User $user
     */
    public static function subscribe(User $user)
    {
        Subscription::firstOrCreate([
            'user_id' => $user->id,
            'is_subscription' => true
        ]);
    }
}
