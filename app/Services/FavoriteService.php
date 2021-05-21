<?php


namespace App\Services;

use App\Models\Ad;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class FavoriteService
 * @package App\Services
 */
class FavoriteService
{
    public function getFavoriteAds()
    {
        $ads = Ad::where('user', '=', Auth::id());
        $user = User::find(Auth::id());
        dd($user->favorites());

    }
}
