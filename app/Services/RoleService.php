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

    /**
     * @param string $name
     * @return HigherOrderBuilderProxy|int|mixed
     * @throws \Exception
     */
    public function getRoleIdByName(string $name)
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

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->checkRole(Role::ADMIN_ROLE);
    }

    /**
     * @return bool
     */
    public function isAuthor(): bool
    {
        return $this->checkRole(Role::AUTHOR_ROLE);
    }

    /**
     * @param string $roleName
     * @return bool
     */
    private function checkRole(string $roleName): bool
    {
        $user = User::find(Auth::id());
        $userRole = $user->role()->get()->first()->name;
        return $userRole === $roleName;
    }
}
