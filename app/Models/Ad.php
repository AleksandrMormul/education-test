<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property string $country
 * @property string $latitude
 * @property string $longitude
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
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

}
