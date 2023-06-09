<?php

namespace App\Models;

use App\Services\AdService;
use App\Services\UpdateCurrencyRate;
use Countries;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Monarobase\CountryList\CountryNotFoundException;

/**
 * App\Models\Ad
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property int $price
 * @property string|null $status_paid
 * @property string $phone_number
 * @property mixed|null $latitude
 * @property mixed|null $longitude
 * @property string $country_code
 * @property string|null $img_src
 * @property Carbon $end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Favorite[] $favorites
 * @property int $price
 * @property-read int|null $favorites_count
 * @property-read string $full_name_country
 * @property-read string $image_url
 * @property-read float $price_currency_e_u_r
 * @property-read float $price_currency_u_a_h
 * @property-read float $price_currency_u_s_d
 * @property-read Invoice|null $invoice
 * @property-read User $user
 * @method static Builder|Ad favoritesForUser(User $user)
 * @method static Builder|Ad newAds()
 * @method static Builder|Ad newModelQuery()
 * @method static Builder|Ad newQuery()
 * @method static Builder|Ad notPaid()
 * @method static Builder|Ad query()
 * @method static Builder|Ad visibleForDate()
 * @method static Builder|Ad whereCountryCode($value)
 * @method static Builder|Ad whereCreatedAt($value)
 * @method static Builder|Ad whereDescription($value)
 * @method static Builder|Ad whereEndDate($value)
 * @method static Builder|Ad whereId($value)
 * @method static Builder|Ad whereImgSrc($value)
 * @method static Builder|Ad whereLatitude($value)
 * @method static Builder|Ad whereLongitude($value)
 * @method static Builder|Ad wherePhoneNumber($value)
 * @method static Builder|Ad wherePrice($value)
 * @method static Builder|Ad whereStatusPaid($value)
 * @method static Builder|Ad whereTitle($value)
 * @method static Builder|Ad whereUpdatedAt($value)
 * @method static Builder|Ad whereUserId($value)
 * @mixin Eloquent
 */
class Ad extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'user_id',
        'status_paid',
        'phone_number',
        'country_code',
        'img_src',
        'end_date',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'end_date' => 'date',
        'price' => 'integer'
    ];

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasOne
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'ad_id');
    }

    /**
     * @param $user
     * @return Ad|Favorite|Model|null
     */
    public function isFavoriteForUser($user)
    {
        return AdService::isFavoriteForUser($this, $user);
    }

    /**
     * @return MorphMany
     */
    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeVisibleForDate($query)
    {
        $now = today()->toDateString();
        return $query->where('end_date', '>=', $now);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotPaid($query)
    {
        return $query->whereNull('status_paid')->orWhereIn('status_paid', [AdService::FREE])
            ->leftJoin('invoices', 'invoices.ad_id', '=', 'ads.id')
            ->whereNull(
                'invoices.paypal_status'
            )
            ->select('ads.*');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNewAds($query)
    {
        return $query->orderBy('created_at', 'asc')->limit(5);
    }

    /**
     * @param $query
     * @param User $user
     * @return mixed
     */
    public function scopeFavoritesForUser($query, User $user)
    {
        return $query->join('favorites', function (JoinClause $join) {
            $join->where('favorites.favoriteable_type', self::class)
                ->whereColumn('favorites.favoriteable_id', 'ads.id');
        })
            ->where('favorites.user_id', $user->id)->select('ads.*', 'favorites.favoriteable_id');
    }

    /**
     * @return string
     * @throws CountryNotFoundException
     */
    public function getFullNameCountryAttribute(): string
    {
        return Countries::getOne($this->country_code, Lang::getLocale());
    }

    /**
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        return AdService::getImageUrl($this);
    }

    /**
     * @return float
     */
    public function getPriceCurrencyUSDAttribute(): float
    {
        return AdService::convertCurrency($this, UpdateCurrencyRate::DOLLAR);
    }

    /**
     * @return float
     */
    public function getPriceCurrencyEURAttribute(): float
    {
        return AdService::convertCurrency($this, UpdateCurrencyRate::EURO);
    }

    /**
     * @return float
     */
    public function getPriceCurrencyUAHAttribute(): float
    {
        return AdService::convertCurrency($this, UpdateCurrencyRate::UAH);
    }
}
