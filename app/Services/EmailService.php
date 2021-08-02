<?php

namespace App\Services;

use App\Jobs\DeletedByAdminSendEmail;
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

        WeeklySendMail::dispatch($newAds)->onQueue('emails');

    }

    /**
     * @param array $adData
     */
    public static function deletedByAuthorEmail(array $adData)
    {

        $users = User::getUsersWhoHaveFavorites($adData['id'])->get();
        $deletedAt = now();

        foreach ($users as $user) {
            DeletedByAuthorSendEmail::dispatch($adData, $user->toArray(), $deletedAt)
                ->onQueue('emails');
        }
    }

    /**
     * @param array $adData
     */
    public static function deletedByAdminEmail(array $adData)
    {

        $users = User::getUsersWhoHaveFavorites($adData['id'])->get();
        $deletedAt = now();

        foreach ($users as $user) {
            DeletedByAdminSendEmail::dispatch($adData, $user->toArray(), $deletedAt)
                ->onQueue('emails');
        }
    }
}
