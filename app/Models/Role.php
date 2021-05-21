<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property-read Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role query()
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @mixin Eloquent
 */
class Role extends Model
{
    public const ADMIN_ROLE = 'admin';
    public const USER_ROLE = 'user';
    public const AUTHOR_ROLE = 'author';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role',
    ];

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
