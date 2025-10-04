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

    public const BOOKING_STATUS_PENDING    = 0;
    public const BOOKING_STATUS_ACCEPTED   = 1;
    public const BOOKING_STATUS_DEPOSITED  = 2;
    public const BOOKING_STATUS_DELIVERED  = 3;
    public const BOOKING_STATUS_RETURNED   = 4;
    public const BOOKING_STATUS_CANCELLED  = 5;
    public const BOOKING_STATUS_REJECTED   = 6;
    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',
        'vehicle_id',
        'user_id',
        'booking_reference',
        'pickup_date',
        'return_date',
        'booking_date',
        'pickup_location_id',
        'return_location',
        'subtotal',
        'delivery_fee',
        'service_fee',
        'tax_amount',
        'security_deposit',
        'total_amount',
        'booking_status',
        'special_requests',
        'reason',
        'audit_by',
    ];

    protected $casts = [
        'pickup_date'       => 'datetime',
        'return_date'       => 'datetime',
        'booking_date'      => 'datetime',
        'subtotal'          => 'decimal:2',
        'delivery_fee'      => 'decimal:2',
        'service_fee'       => 'decimal:2',
        'tax_amount'        => 'decimal:2',
        'security_deposit'  => 'decimal:2',
        'total_amount'      => 'decimal:2',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), []);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    // Relations
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pickupLocation()
    {
        return $this->belongsTo(VehicleLocation::class, 'pickup_location_id');
    }

    public function auditor()
    {
        return $this->belongsTo(User::class, 'audit_by');
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
