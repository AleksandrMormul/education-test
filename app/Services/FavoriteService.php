<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Favorite;
use App\Models\User;

/**
 * Class FavoriteService
 * @package App\Services
 */
class FavoriteService
{
    /**
     * @param Ad $ad
     * @param User $user
     * @return array
     */
    public static function toggleFavorite(Ad $ad, User $user): array
    {
        if (
            Favorite::where([
                    ['user_id', $user->id],
                    ['favoriteable_type', Ad::class],
                    ['favoriteable_id', $ad->id],
                ])
                ->doesntExist()
        ) {
            $favorite = new Favorite(['user_id' => $user->id]);
            $ad->favorites()->save($favorite);

            return ['favorite' => 'enabled'];

        }

        $favorite = UserService::userAdFavorite($user, $ad);

        if ($favorite) {
            $favorite->delete();
        }

        return ['favorite' => 'disabled'];
    }
}
