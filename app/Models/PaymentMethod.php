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
    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
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

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
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
