<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @param User $user
     * @return bool
     */
    public static function isAdmin(User $user): bool
    {
        return self::checkRole($user, RoleService::ADMIN_ROLE);
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function isAuthor(User $user): bool
    {
        return self::checkRole($user, RoleService::AUTHOR_ROLE);
    }

    /**
     * @param User $user
     * @param string $roleName
     * @return bool
     */
    public static function checkRole(User $user, string $roleName): bool
    {
        $userRole = $user->role()->get()->first()->name;
        return $userRole === $roleName;
    }
}
