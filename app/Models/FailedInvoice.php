<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\FailedInvoice
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $user_id
 * @property int|null $ad_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|FailedInvoice newModelQuery()
 * @method static Builder|FailedInvoice newQuery()
 * @method static Builder|FailedInvoice query()
 * @method static Builder|FailedInvoice whereAdId($value)
 * @method static Builder|FailedInvoice whereCreatedAt($value)
 * @method static Builder|FailedInvoice whereId($value)
 * @method static Builder|FailedInvoice whereInvoiceId($value)
 * @method static Builder|FailedInvoice whereUpdatedAt($value)
 * @method static Builder|FailedInvoice whereUserId($value)
 * @mixin Eloquent
 */
class FailedInvoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ad_id',
        'invoice_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ad_id' => 'integer',
        'invoice_id' => 'integer',
        'user_id' => 'integer',
    ];
}
