<?php


namespace App\Services\Api;


use App\Jobs\WeeklySendMail;
use App\Models\Ad;

/**
 * Class EmailService
 * @package App\Services\Api
 */
class EmailService
{
    public static function weeklyEmail()
    {
        $newAds = Ad::newAds()->get();
        WeeklySendMail::dispatch($newAds);
    }
}
