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
        $this->appends = array_merge(parent::getAppends(), []);
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

    //

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
