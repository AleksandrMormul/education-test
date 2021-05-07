<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Lang;

/**
 * App\Models\Ad
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $img_src
 * @property string $country_code
 * @property string $phone_number
 * @property string $latitude
 * @property string $longitude
 * @property \Illuminate\Support\Carbon end_date
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereImgSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereLongitude($value)
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

    /**
     * @param $countryCode
     * @return string
     */
    public function getFullNameContryAttribute()
    {
        return \Countries::getOne($this->country_code, Lang::getLocale());
    }

}
