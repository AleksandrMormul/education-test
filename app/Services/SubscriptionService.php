<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\URL;

/**
 * Class SubscriptionService
 * @package App\Services
 */
class SubscriptionService
{
    public const SUBSCRIBED = 'SUBSCRIBED';
    public const UNSUBSCRIBED = 'UNSUBSCRIBED';

    /**
     * @param User $user
     * @return array
     * @throws Exception
     */
    public static function subscribe(User $user): array
    {
        if (Subscription::whereUserId($user->id)->doesntExist()) {
            Subscription::create([
                'user_id' => $user->id,
            ]);
            return [self::SUBSCRIBED => true];
        }

        self::unsubscribe($user);
        return [self::UNSUBSCRIBED => true];
    }

    /**
     * @param User $user
     * @throws Exception
     */
    public static function unsubscribe(User $user)
    {
        Subscription::whereUserId($user->id)->delete();
    }

    /**
     * @param User $user
     * @return string
     */
    public static function getSignedUrl(User $user): string
    {
        return URL::signedRoute('unsubscribe', ['user' => $user->id]);
    }
}
