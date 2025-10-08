<?php

namespace App\Models;

use App\Models\BaseModel;

class Rentalcheckout extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    public const FUEL_LEVEL_EMPTY         = 1;
    public const FUEL_LEVEL_QUARTER       = 2;
    public const FUEL_LEVEL_HALF          = 3;
    public const FUEL_LEVEL_THREE_QUARTER = 4;
    public const FUEL_LEVEL_FULL          = 5;


    /* ================================================================
     * *** ATTRIBUTES ***
     ================================================================ */







    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',
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
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by', 'id');
    }

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    public function scopeSelf($query)
    {
        return $query->where('created_by', user()->id);
    }
    public function scopeEmpty($query)
    {
        return $query->where('fuel_level_start', self::FUEL_LEVEL_EMPTY);
    }
    public function scopeQuarter($query)
    {
        return $query->where('fuel_level_start', self::FUEL_LEVEL_QUARTER);
    }
    public function scopeHalf($query)
    {
        return $query->where('fuel_level_start', self::FUEL_LEVEL_HALF);
    }
    public function scopeThreeQuarter($query)
    {
        return $query->where('fuel_level_start', self::FUEL_LEVEL_THREE_QUARTER);
    }
    public function scopeFull($query)
    {
        return $query->where('fuel_level_start', self::FUEL_LEVEL_FULL);
    }

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    public function getFuelLavelStartLabelAttribute()
    {
        return match ($this->fuel_level_start) {
            self::FUEL_LEVEL_EMPTY => 'Empty',
            self::FUEL_LEVEL_QUARTER => 'Quarter',
            self::FUEL_LEVEL_HALF => 'Half',
            self::FUEL_LEVEL_THREE_QUARTER => 'Three Quarter',
            self::FUEL_LEVEL_FULL => 'Full',
            default => 'Unknown',
        };
    }
    public function getFuelLavelStartColorAttribute()
    {
        return match ((int)$this->fuel_level_start) {
            self::FUEL_LEVEL_EMPTY => 'badge-danger',
            self::FUEL_LEVEL_QUARTER => 'badge-warning',
            self::FUEL_LEVEL_HALF => 'badge-info',
            self::FUEL_LEVEL_THREE_QUARTER => 'badge-primary',
            self::FUEL_LEVEL_FULL => 'badge-success',
            default => 'badge-secondary',
        };
    }

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
