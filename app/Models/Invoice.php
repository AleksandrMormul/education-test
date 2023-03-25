<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $ad_id
 * @property string $order_id
 * @property string|null $paypal_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read FailedInvoice|null $failedInvoice
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereAdId($value)
 * @method static Builder|Invoice whereCreatedAt($value)
 * @method static Builder|Invoice whereId($value)
 * @method static Builder|Invoice whereOrderId($value)
 * @method static Builder|Invoice wherePaypalStatus($value)
 * @method static Builder|Invoice whereUpdatedAt($value)
 * @method static Builder|Invoice whereUserId($value)
 * @mixin Eloquent
 */
class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ad_id',
        'order_id',
        'paypal_status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'ad_id' => 'integer',
    ];

    /**
     * @return HasOne
     */
    public function failedInvoice(): HasOne
    {
        return $this->hasOne(FailedInvoice::class, 'invoice_id');
    }
}
