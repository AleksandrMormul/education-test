<?php


namespace App\Services\Api;


use App\Jobs\DeletedByAuthorSendEmail;
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

    /**
     * @param array $adData
     */
    public static function deletedByAuthorEmail(array $adData)
    {
        try {
            \Log::info('function deletedByAuthorEmail run.....');
            $ad = new Ad($adData);
            $users = User::getUsersWhoHaveFavorites($ad)->get();
            //dd($user);
            $deletedAt = now();
            foreach ($users as $user) {
                \Log::info('dispatch job.....');
                DeletedByAuthorSendEmail::dispatch($ad, $user, $deletedAt)->onQueue('delete-by-author-emails');
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
