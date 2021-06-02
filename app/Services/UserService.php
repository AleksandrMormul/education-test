<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Ad;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
     * @param array $ids
     * @return \Illuminate\Support\Collection
     */
    public static function userAdFavorite(User $user, array $ids): \Illuminate\Support\Collection
    {
        return $user->favorites()
            ->whereIn('favoriteable_id', $ids)
            ->with('favoriteable')
            ->pluck('favoriteable_id');
    }
}
