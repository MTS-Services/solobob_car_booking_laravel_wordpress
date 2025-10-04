<?php

namespace App\Models;

use App\Models\BaseModel;

class Payment extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    public const METHOD_STRIPE = 1;
    public const METHOD_PAYPAL = 2;

    public const TYPE_DEPOSIT = 1;
    public const TYPE_FINAL = 2;
    public const TYPE_ADDITIONAL = 3;

    public const STATUS_PENDING = 0;
    public const STATUS_PAID = 1;
    public const STATUS_REFUNDED = 2;
    public const STATUS_FAILED = 3;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',
        'booking_id',
        'user_id',
        'payment_method',
        'type',
        'status',
        'amount',
        'note',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $hidden = [];

    /**
     * Define the attribute casts for the model.
     */
    protected function casts(): array
    {
        return [];
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), []);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            self::METHOD_STRIPE => 'Stripe',
            self::METHOD_PAYPAL => 'PayPal',
            default => 'Unknown',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PAID => 'Paid',
            self::STATUS_REFUNDED => 'Refunded',
            self::STATUS_FAILED => 'Failed',
            default => 'Unknown',
        };
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
