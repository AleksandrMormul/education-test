<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * Class FavoriteService
 * @package App\Services
 */
class FavoriteService
{
    /**
     * @return LengthAwarePaginator
     * @throws BindingResolutionException
     */
    public static function getFavoriteAds(): LengthAwarePaginator
    {
        $user = User::find(Auth::id());

        $favoriteAds = $user->favoriteAds(Ad::class);

        return PaginateService::paginate($favoriteAds, 15);
    }
}
