<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CurrencyRate
 *
 * @property int $id
 * @property int $dollar
 * @property int $euro
 * @property int $grivna
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CurrencyRate newModelQuery()
 * @method static Builder|CurrencyRate newQuery()
 * @method static Builder|CurrencyRate query()
 * @method static Builder|CurrencyRate whereCreatedAt($value)
 * @method static Builder|CurrencyRate whereDollar($value)
 * @method static Builder|CurrencyRate whereEuro($value)
 * @method static Builder|CurrencyRate whereGrivna($value)
 * @method static Builder|CurrencyRate whereId($value)
 * @method static Builder|CurrencyRate whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CurrencyRate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dollar',
        'euro',
        'grivna',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dollar' => 'integer',
        'euro ' => 'integer',
        'grivna ' => 'integer',
    ];
}
