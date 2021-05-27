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
     * @param Ad $ad
     * @return array
     */
    public static function toggleFavorite(Ad $ad, User $user): array
    {
        if (
            Favorite::where('user_id', '=', $user->id)
                ->where('favoriteable_type', '=', Ad::class)
                ->where('favoriteable_id', '=', $ad->id)
                ->doesntExist()
        ) {
            $favorite = new Favorite(['user_id' => $user->id]);
            $ad->favorites()->save($favorite);

            return ['favorite' => 'enabled'];

        }

        $favorite = UserService::userAdFavorite($user, $ad, Ad::class);
        Favorite::destroy($favorite[0]->id);

        return ['favorite' => 'disabled'];
    }
}
