<?php

namespace App\Models;

use App\Models\BaseModel;

class Transaction extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    public const STATUS_PENDING   = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED    = 'failed';
    public const STATUS_REFUNDED  = 'refunded';

    public const TYPE_BOOKING_PAYMENT   = 'booking_payment';
    public const TYPE_SECURITY_DEPOSIT  = 'security_deposit';
    public const TYPE_REFUND            = 'refund';
    public const TYPE_PAYOUT            = 'payout';
    public const TYPE_ADDITIONAL_CHARGE = 'additional_charge';

    public const CURRENCY_USD = 'USD';
    public const CURRENCY_EUR = 'EUR';


    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'booking_id',
        'user_id',
        'transaction_type',
        'amount',
        'currency',
        'payment_method_id',
        'transaction_status',
        'payment_gateway',
        'gateway_transaction_id',
        'gateway_response',
        'description',
        'processed_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'gateway_response' => 'array',
        'processed_at' => 'datetime',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), []);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    /** Relationships */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
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
