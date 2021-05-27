<?php


namespace App\Services;


use App\Models\Subscription;
use Illuminate\Http\Request;

/**
 * Class SubscriptionService
 * @package App\Services
 */
class SubscriptionService
{

    /**
     * @param Request $request
     */
    public static function subscribe(Request $request)
    {
        Subscription::create([
            'user_id' => $request->user()->id,
            'is_subscription' => true
        ]);
    }

}
