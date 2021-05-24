<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public static function isAdmin(User $user): bool
    {
        return self::checkRole($user, RoleService::ADMIN_ROLE);
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public static function isAuthor(User $user): bool
    {
        return self::checkRole($user, RoleService::AUTHOR_ROLE);
    }

    /**
     * @param User $user
     * @param string $roleName
     * @return bool
     * @throws \Exception
     */
    public static function checkRole(User $user, string $roleName): bool
    {
        return $user->role_id === RoleService::getRoleIdByName($roleName);
    }

    /**
     * @param User $user
     * @param Ad $ad
     * @param $class
     * @return Collection
     */
    public static function userAdFavorite(User $user, Ad $ad, $class): Collection
    {
        return $user->favorites()->where('favoriteable_type', $class)
            ->where('favoriteable_id', '=', $ad->id)
            ->with('favoriteable')
            ->get();
    }

    /**
     * @param User $user
     * @param $class
     * @return Collection|\Illuminate\Support\Collection
     */
    public static function userAdsFavorite(User $user, $class)
    {
        return $user->favorites()
            ->where('favoriteable_type', $class)
            ->with('favoriteable')
            ->get()
            ->mapWithKeys(function ($item) {

                if (isset($item['favoriteable'])) {
                    return [$item['favoriteable']->id => $item['favoriteable']];
                }

                return [];
            });
    }

}
