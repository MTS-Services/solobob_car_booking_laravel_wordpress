<?php

namespace App\Models;

use App\Models\BaseModel;
use Faker\Provider\ar_EG\Address;

class PaymentMethod extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    // comment("'1 = credit_card', '2 = debit_card', '3 = paypal', '4 = bank_account'");

    public const METHOD_TYPE_CREDIT_CARD = 1;
    public const METHOD_TYPE_DEBIT_CARD  = 2;
    public const METHOD_TYPE_PAYPAL      = 3;
    public const METHOD_TYPE_BANK_ACCOUNT = 4;



    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'method_type_label',
            'method_type_color',
        ]);
    }

    public function getMethodTypeLabelAttribute()
    {
        return match ($this->method_type) {
            self::METHOD_TYPE_CREDIT_CARD => 'Credit Card',
            self::METHOD_TYPE_DEBIT_CARD => 'Debit Card',
            self::METHOD_TYPE_PAYPAL => 'PayPal',
            self::METHOD_TYPE_BANK_ACCOUNT => 'Bank Account',
            default => 'Unknown',
        };
    }

    public function getMethodTypeColorAttribute()
    {
        return match ($this->method_type) {
            self::METHOD_TYPE_CREDIT_CARD => 'badge-info',
            self::METHOD_TYPE_DEBIT_CARD => 'badge-info',
            self::METHOD_TYPE_PAYPAL => 'badge-info',
            self::METHOD_TYPE_BANK_ACCOUNT => 'badge-info',
            default => 'badge-info',
        };
    }
    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',
        'payment_id',
        'user_id',
        'billing_address_id',
        'method_type',
        'provider',
        'last_four',
        'card_brand',
        'expiry_month',
        'expiry_year',
        'cardholder_name',

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



    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    public function scopeSelf($query)
    {
        return $query->where('user_id', user()->id);
    }
    public function scopeCretditCard($query){
        return $query->where('method_type', self::METHOD_TYPE_CREDIT_CARD);
    }
    public function scopeDebitCard($query){
        return $query->where('method_type', self::METHOD_TYPE_DEBIT_CARD);
    }
    public function scopePaypal($query){
        return $query->where('method_type', self::METHOD_TYPE_PAYPAL);
    }
    public function scopeBankAccount($query){
        return $query->where('method_type', self::METHOD_TYPE_BANK_ACCOUNT);
    }
    
    // METHOD_TYPE_CREDIT_CARD

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
