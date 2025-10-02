<?php

namespace App\Models;

use App\Models\BaseModel;

class Rentalcheckout extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    // public const ACTIVE = 1;
    // public const INACTIVE = 0;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'booking_id',
        'checkout_datetime',
        'mileage_end',
        'fuel_level_end',
        'vehicle_condition_notes',
        'damage_photos',
        'additional_charges',
        'additional_charges_reason',
        'checkout_signature_url',
        'performed_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'checkout_datetime' => 'datetime',
        'damage_photos' => 'array',
        'fuel_level_end' => 'integer',
        'additional_charges' => 'decimal:2',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), []);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by');
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
