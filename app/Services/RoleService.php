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
     * @return int
     * @throws \RuntimeException
     */
    public static function getRoleIdByName(string $name)
    {
        $key = self::CACHE_PREFIX . $name;

        return Cache::rememberForever($key, function () use ($name) {
            try {
                return Role::whereName($name)->firstOrFail()->id;
            } catch (ModelNotFoundException $exception) {
                Log::warning('Check if role ' . $name . ' exist in database. Or run artisan db:seed.');

                throw new \RuntimeException('The' . $name . ' role is not in the database');
            }
        });
    }
}
