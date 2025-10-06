<?php

namespace App\Models;

use App\Models\BaseModel;

class Payout extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    // payout_status tinyint(4) [DEFAULT: 'pending', note: "'pending', 'processing', 'completed', 'failed'"]
    // payout_method tinyint(4) [note: "'bank_transfer', 'paypal', 'stripe'"]

    public const STATUS_PENDING    = 1;
    public const STATUS_PROCESSING = 2;
    public const STATUS_COMPLETED  = 3;
    public const STATUS_FAILED     = 4;

    public const METHOD_BANK_TRANSFER = 1;
    public const METHOD_PAYPAL        = 2;
    public const METHOD_STRIPE        = 3;
    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'owner_id',
        'booking_id',
        'amount',
        'platform_fee',
        'net_amount',
        'payout_status',
        'payout_method',
        'payout_details',
        'scheduled_date',
        'completed_at',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'payout_details' => 'array',
        'scheduled_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'payout_status_label',
            'payout_status_color',
            'payout_method_label',
            'payout_method_color',

        ]);
    }

    /* ================================================================
     * *** ATTRIBUTES ***
     ================================================================ */
    public function getPayoutStatusLabelAttribute()
    {
        return match ($this->payout_status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_FAILED => 'Failed',
            default => 'Unknown',
        };
    }
    public function getPayoutMethodColorAttribute()
    {
        return match ($this->payout_method) {
            self::METHOD_BANK_TRANSFER => 'badge-info',
            self::METHOD_PAYPAL => 'badge-info',
            self::METHOD_STRIPE => 'badge-info',
            default => 'badge-info',
        };
    }
    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    public function scopeSelf($query)
    {
        return $query->where('owner_id', user()->id);
    }
    public function scopePending($query)
    {
        return $query->where('payout_status', self::STATUS_PENDING);
    }
    public function scopeCompleted($query)
    {
        return $query->where('payout_status', self::STATUS_COMPLETED);
    }
    public function scopeFailed($query)
    {
        return $query->where('payout_status', self::STATUS_FAILED);
    }

    public function scopdeBankTransfer($query)
    {
        return $query->where('payout_method',self::METHOD_BANK_TRANSFER);
    }
    public function scopePaypal($query)
    {
        return $query->where('payout_method',self::METHOD_PAYPAL);
    }
    public function scopeStripe($query)
    {
        return $query->where('payout_method',self::METHOD_STRIPE);
    }

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
