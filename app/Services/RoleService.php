<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Class RoleService
 * @package App\Services
 */
class RoleService
{
    public const ADMIN_ROLE = 'admin';
    public const USER_ROLE = 'user';
    public const AUTHOR_ROLE = 'author';

    /**
     * @param string $name
     * @return HigherOrderBuilderProxy|int|mixed
     * @throws \Exception
     */
    public static function getRoleIdByName(string $name)
    {
        $key = 'role_' . $name;
        $role = Cache::get($key);

        if (is_null($role)) {
            $role = Role::whereName($name)->first();
            Cache::forever($key, $role);
        }

        if (!$role) {
            throw new \Exception('Check if role ' . $name . ' exist in database. Or run artisan db:seed.');
        }

        return $role->id;
    }
}
