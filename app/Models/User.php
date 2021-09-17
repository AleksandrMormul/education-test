<?php

namespace App\Models;

use App\Services\UserService;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\JoinClause;
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
 * @property int|null $role_id
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read Collection|Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read Collection|Invoice[] $invoice
 * @property-read int|null $invoice_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Role|null $role
 * @property-read Subscription|null $subscription
 * @method static Builder|User getUsersWhoHaveFavorites($ad)
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
 * @method static Builder|User getSubscribedUsers()
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
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
     * user
     *
     * @return HasMany
     */
    public function invoice(): HasMany
    {
        return $this->hasMany(Invoice::class, 'user_id');
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
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * @return HasOne
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * @return bool
     * @throws \RuntimeException
     */
    public function isAdmin(): bool
    {
        return UserService::isAdmin($this);
    }

    /**
     * @return bool
     * @throws \RuntimeException
     */
    public function isAuthor(): bool
    {
        return UserService::isAuthor($this);
    }

    /**
     * @param $query
     * @param $adId
     * @return mixed
     */
    public function scopeGetUsersWhoHaveFavorites($query, $adId)
    {
        return $query->join('favorites', function (JoinClause $join) {
            $join->where('favorites.favoriteable_type', Ad::class)
                ->whereColumn('favorites.user_id', 'users.id');
        })
            ->where('favorites.favoriteable_id', $adId);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGetSubscribedUsers($query)
    {
        return $query
            ->join('subscriptions', 'subscriptions.user_id', 'users.id')
            ->select('users.*');
    }

    /**
     * @param string $roleName
     * @return bool
     * @throws \RuntimeException
     */
    private function checkRole(string $roleName): bool
    {
        return UserService::checkRole($this, $roleName);
    }
}
