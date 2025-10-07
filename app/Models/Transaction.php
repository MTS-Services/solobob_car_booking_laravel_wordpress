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
        $this->appends = array_merge(parent::getAppends(), [
            'transaction_status_label',
            'transaction_status_color',
            'transaction_type_label',
            'transaction_type_color',
        ]);
    }
    
    /* ================================================================
     * *** Attributes ***
     ================================================================ */
        public function getTransactionStatusLabelAttribute()
        {
            return match ($this->transaction_status) {
                self::STATUS_PENDING   => 'Pending',
                self::STATUS_COMPLETED => 'Completed',
                self::STATUS_FAILED    => 'Failed',
                default => 'Unknown',
            };
        }
        public function getTransactionStatusColorAttribute()
        {
            return match ($this->transaction_status) {
                self::STATUS_PENDING   => 'warning',
                self::STATUS_COMPLETED => 'success',
                self::STATUS_FAILED    => 'danger',
                default => 'warning',
            };
        }
        public function getTransactionTypeLabelAttribute()
        {
            return match ($this->transaction_type) {
                self::TYPE_BOOKING_PAYMENT   => 'Booking Payment',
                self::TYPE_SECURITY_DEPOSIT  => 'Security Deposit',
                self::TYPE_REFUND            => 'Refund',
                self::TYPE_PAYOUT            => 'Payout',
                self::TYPE_ADDITIONAL_CHARGE => 'Additional Charge',
                default => 'Unknown',
            };
        }
        public function getTransactionTypeColorAttribute()
        {
            return match ($this->transaction_type) {
                self::TYPE_BOOKING_PAYMENT   => 'warning',
                self::TYPE_SECURITY_DEPOSIT  => 'warning',
                self::TYPE_REFUND            => 'danger',
                self::TYPE_PAYOUT            => 'success',
                self::TYPE_ADDITIONAL_CHARGE => 'warning',
                default => 'warning',
            };
        }
     /* ================================================================
     * *** RELATIONS ***
     ================================================================ */
    public function scopeSelf()
    {
        return $this->where('user_id', user()->id);
    }
    public function scopeBookingPayment()
    {
        return $this->where('transaction_type', self::TYPE_BOOKING_PAYMENT);
    }
    public function scopeSecurityDeposit()
    {
        return $this->where('transaction_type', self::TYPE_SECURITY_DEPOSIT);   
    }
    public function scopeRefund()
    {
        return $this->where('transaction_type', self::TYPE_REFUND);
    }
    public function scopePayout()
    {
        return $this->where('transaction_type', self::TYPE_PAYOUT);
    }
    public function scopePending()
    {
        return $this->where('transaction_status', self::STATUS_PENDING);
    }
    public function scopeCompleted()
    {
        return $this->where('transaction_status', self::STATUS_COMPLETED);
    }
    public function scopeFailed()
    {
        return $this->where('transaction_status', self::STATUS_FAILED);
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
