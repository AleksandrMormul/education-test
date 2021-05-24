<?php


namespace App\Services;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class FavoriteService
 * @package App\Services
 */
class FavoriteService
{
    public static function getFavoriteAds()
    {
        $ads = Ad::where('user', '=', Auth::id());
        $user = User::find(Auth::id());
        return $user->favorites;

    }
}
