<?php

namespace App\Models;

use App\Services\AdService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Lang;

/**
 * App\Models\Ad
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property string $phone_number
 * @property mixed|null $latitude
 * @property mixed|null $longitude
 * @property string $country_code
 * @property string|null $img_src
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_image_path
 * @property-read string $full_name_country
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Ad adByDate()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereImgSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereUserId($value)
 * @mixin \Eloquent
 */
class Ad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
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
        'end_date' => 'date'
    ];

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeAdByDate($query)
    {
        $now = Carbon::now()->addDay()->toDateString();
        return $query->where('end_date', '>=', $now)
            ->orderBy('end_date', 'asc');
    }

    /**
     * @return string
     */
    public function getFullNameCountryAttribute()
    {
        return \Countries::getOne($this->country_code, Lang::getLocale());
    }

    /**
     * @return string
     */
    public function getFullImagePathAttribute(): string
    {
        $adService = resolve(AdService::class);
        if ($this->img_src) {
            return $adService->getImagePath() . '/' . $this->img_src;
        } else {
            return $adService->getDefaultImage();
        }
    }
}
