<?php


namespace App\Services\Api;


use App\Jobs\WeeklySendMail;
use App\Models\Ad;
use App\Models\User;
use App\Services\UserService;

/**
 * Class EmailService
 * @package App\Services\Api
 */
class EmailService
{
    public static function weeklyEmail()
    {
        $newAds = Ad::newAds()->get();
        $usersIds = UserService::getSubscribeUsersIds();
        foreach ($usersIds as $userId) {
            $user = User::findOrFail($userId->user_id);
            WeeklySendMail::dispatch($newAds, $user)->onQueue('weekly-emails');
        }
    }
}
