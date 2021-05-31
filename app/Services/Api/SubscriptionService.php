<?php

namespace App\Services\Api;

use App\Models\Subscription;
use App\Models\User;
use Exception;

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
        Subscription::create([
            'user_id' => $user->id,
            'is_subscription' => true
        ]);
    }

    /**
     * @param User $user
     * @throws Exception
     */
    public static function unsubscribe(User $user)
    {
        Subscription::whereUserId($user->id)->delete();
    }
}
