<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * Class FavoriteService
 * @package App\Services
 */
class FavoriteService
{
    /**
     * @return HigherOrderCollectionProxy|mixed
     */
    public static function getFavoriteAds()
    {
        $user = User::find(Auth::id());

        return $user->favorites()->paginate(5);
    }
}
