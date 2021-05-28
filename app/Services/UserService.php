<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RuntimeException;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @param User $user
     * @return bool
     * @throws RuntimeException
     */
    public static function isAdmin(User $user): bool
    {
        return self::checkRole($user, RoleService::ADMIN_ROLE);
    }

    /**
     * @param User $user
     * @param string $roleName
     * @return bool
     * @throws RuntimeException
     */
    public static function checkRole(User $user, string $roleName): bool
    {
        return $user->role_id === RoleService::getRoleIdByName($roleName);
    }

    /**
     * @param User $user
     * @return bool
     * @throws RuntimeException
     */
    public static function isAuthor(User $user): bool
    {
        return self::checkRole($user, RoleService::AUTHOR_ROLE);
    }

    /**
     * @param User $user
     * @param Ad $ad
     * @return Model|HasMany|object|null
     */
    public static function userAdFavorite(User $user, Ad $ad)
    {
        return $user->favorites()->where('favoriteable_type', Ad::class)
            ->where('favoriteable_id', '=', $ad->id)
            ->with('favoriteable')
            ->first();
    }
}
