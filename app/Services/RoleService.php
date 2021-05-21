<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class RoleService
 * @package App\Services
 */
class RoleService
{
    public const ADMIN_ROLE = 'admin';
    public const USER_ROLE = 'user';
    public const AUTHOR_ROLE = 'author';
    private const CACHE_PREFIX = 'role_';

    /**
     * @param string $name
     * @return HigherOrderBuilderProxy|int|mixed
     * @throws \Exception
     */
    public static function getRoleIdByName(string $name)
    {
        $key = self::CACHE_PREFIX . $name;
        Cache::rememberForever($key,function () use ($name){
            try {
                return Role::whereName($name)->firstOrFail();
            } catch (ModelNotFoundException $exception) {
                Log::warning('Check if role ' . $name . ' exist in database. Or run artisan db:seed.');
                throw new \Exception('The' . $name . ' role is not in the database');
            }
        });
    }
}
