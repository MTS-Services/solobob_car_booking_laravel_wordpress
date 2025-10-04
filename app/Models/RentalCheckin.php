<?php

namespace App\Models;

use App\Models\BaseModel;

class RentalCheckin extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    public const FUEL_LEVEL_EMPTY         = 0;
    public const FUEL_LEVEL_QUARTER       = 1;
    public const FUEL_LEVEL_HALF          = 2;
    public const FUEL_LEVEL_THREE_QUARTER = 3;
    public const FUEL_LEVEL_FULL          = 4;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'booking_id',
        'checkin_datetime',
        'mileage_start',
        'fuel_level_start',
        'vehicle_condition_notes',
        'damage_photos',
        'checkin_signature_url',
        'performed_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'checkin_datetime' => 'datetime',
        'damage_photos' => 'array',
        'fuel_level_start' => 'integer',
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
