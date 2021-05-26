<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Favorite;
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

        $favoriteAds = UserService::userAdsFavorite($user, Ad::class);

        return PaginateService::paginate($favoriteAds, 15);
    }

    /**
     * @param Ad $ad
     * @return array
     */
    public static function toggleFavorite(Ad $ad): array
    {
        if (
            Favorite::where('user_id', '=', Auth::id())
            ->where('favoriteable_id', '=', $ad->id)
            ->doesntExist()
        ) {
            $favorite = new Favorite(['user_id' => Auth::id()]);
            $ad->favorites()->save($favorite);

            return ['favorite' => 'enabled'];

        }

        $user = Auth::user();
        $favorite = UserService::userAdFavorite($user, $ad, Ad::class);
        Favorite::destroy($favorite[0]->id);

        return ['favorite' => 'disabled'];
    }
}
