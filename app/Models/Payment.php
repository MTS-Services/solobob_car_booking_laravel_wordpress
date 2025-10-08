<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        $this->appends = array_merge(parent::getAppends(), [
            'payment_method_label',
            'payment_method_color',
            'status_label',
            'status_color',
            'type_label',
            'type_color',
            'amount_formatted',
        ]);
    }


    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function paymentMethod(): HasMany
    {
        return $this->hasMany(PaymentMethod::class, 'payment_id', 'id');
    }

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */
    public function scopeSelf()
    {
        return $this->where('user_id', user()->id);
    }
    public function scopeStripe($query)
    {
        return $query->where('payment_method', self::METHOD_STRIPE);
    }
    public function scopePaypal($query)
    {
        return $query->where('payment_method', self::METHOD_PAYPAL);
    }
    public function scopeDeposit($query)
    {
        return $query->where('type', self::TYPE_DEPOSIT);
    }
    public function scopeFinal($query)
    {
        return $query->where('type', self::TYPE_FINAL);
    }
    public function scopeAdditional($query)
    {
        return $query->where('type', self::TYPE_ADDITIONAL);
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }
    // please define all scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
    public function scopeRefunded($query)
    {
        return $query->where('status', self::STATUS_REFUNDED);
    }



    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            self::METHOD_STRIPE => 'Stripe',
            self::METHOD_PAYPAL => 'PayPal',
            default => 'Unknown',
        };
    }
    public function getPaymentMethodColorAttribute(): string
    {
        return match ((int)$this->payment_method) {
            self::METHOD_STRIPE => 'badge-info',
            self::METHOD_PAYPAL => 'badge-success',
            default => 'badge-secondary',
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

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_DEPOSIT => 'Deposit',
            self::TYPE_FINAL => 'Final',
            self::TYPE_ADDITIONAL => 'Additional',
            default => 'Unknown',
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match ((int)$this->type) {
            self::TYPE_DEPOSIT => 'badge-info',
            self::TYPE_FINAL => 'badge-success',
            self::TYPE_ADDITIONAL => 'badge-warning',
            default => 'badge-secondary',
        };
    }

    public function getStatusColorAttribute()
    {
        return match ((int)$this->status) {
            self::STATUS_PENDING => 'badge-secondary',
            self::STATUS_PAID => 'badge-success',
            self::STATUS_REFUNDED => 'badge-info',
            self::STATUS_FAILED => 'badge-warning',
            default => 'badge-secondary',
        };
    }

    public function getAmountFormattedAttribute(): string
    {
        return number_format($this->amount, 2);
    }

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
