<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $role_id
 * @property-read Collection|Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read Collection|Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Role|null $roles
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRoleId($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_AUTHOR = 'author';
    const ROLE_USER = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role_id ' => 'integer',
    ];

    /**
     * Ads
     *
     * @return HasMany
     */
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    /**
     * @param $class
     * @param int $adId
     * @return Collection
     */
    public function favorite($class, int $adId): Collection
    {
        return $this->favorites()->where('favoriteable_type', $class)
            ->where('favoriteable_id', '=', $adId)
            ->with('favoriteable')
            ->get();
    }

    /**
     * Ads
     *
     * @return HasMany
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->checkRole(self::ROLE_ADMIN);
    }

    /**
     * @param string $roleName
     * @return bool
     */
    private function checkRole(string $roleName): bool
    {
        foreach ($this->roles()->get() as $role) {
            if ($role->role === $roleName) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return BelongsTo
     */
    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * @return bool
     */
    public function isAuthor(): bool
    {
        return $this->checkRole(self::ROLE_AUTHOR);
    }
}
