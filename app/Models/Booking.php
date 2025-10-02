<?php

namespace App\Models;

use App\Models\BaseModel;

class Booking extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */
    public const PAYMENT_STATUS_PENDING   = 0;
    public const PAYMENT_STATUS_PAID      = 1;
    public const PAYMENT_STATUS_REFUNDED  = 2;
    public const PAYMENT_STATUS_FAILED    = 3;

    // ->comment("0 = pending, 1 = confirmed, 2 = active, 3 = completed, 4 = cancelled, 5 = rejected");
    public const BOOKING_STATUS_PENDING    = 0;
    public const BOOKING_STATUS_CONFIRMED  = 1;
    public const BOOKING_STATUS_ACTIVE     = 2;
    public const BOOKING_STATUS_COMPLETED  = 3;
    public const BOOKING_STATUS_CANCELLED  = 4;
    public const BOOKING_STATUS_REJECTED   = 5;
    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'vehicle_id',
        'renter_id',
        'owner_id',
        'booking_reference',
        'start_date',
        'end_date',
        'pickup_time',
        'return_time',
        'pickup_location_id',
        'return_location_id',
        'total_days',
        'daily_rate',
        'subtotal',
        'delivery_fee',
        'service_fee',
        'tax_amount',
        'security_deposit',
        'total_amount',
        'booking_status',
        'payment_status',
        'special_requests',
        'cancellation_reason',
        'cancelled_by',
        'cancelled_at',
        'confirmed_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'pickup_time' => 'datetime:H:i',
        'return_time' => 'datetime:H:i',
        'cancelled_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'booking_status' => 'integer',
        'payment_status' => 'integer',
        'daily_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), []);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function pickupLocation()
    {
        return $this->belongsTo(VehicleLocation::class, 'pickup_location_id');
    }

    public function returnLocation()
    {
        return $this->belongsTo(VehicleLocation::class, 'return_location_id');
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
