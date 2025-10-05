<?php

namespace App\Models;

use App\Models\BaseModel;
use Carbon\Carbon;

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

    public function timeline()
    {
        return $this->hasOne(BookingStatusTimeline::class, 'booking_id', 'id');
    }


    /* ================================================================
     * *** Booking Status ***
     ================================================================ */
    //
    public static function getBookingStatus(): array
    {
        return [
            self::BOOKING_STATUS_PENDING => 'Pending',
            self::BOOKING_STATUS_ACCEPTED => 'Accepeted',
            self::BOOKING_STATUS_DEPOSITED => 'Deposited',
            self::BOOKING_STATUS_DELIVERED => 'Delevered',
            self::BOOKING_STATUS_RETURNED => 'Returned',
            self::BOOKING_STATUS_CANCELLED => 'Cancelled',
            self::BOOKING_STATUS_REJECTED => 'Rejected',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getBookingStatus()[$this->booking_status] ?? 'Undefined';
    }





    /* ================================================================
     * *** SCOPES ***
     ================================================================ */
    public function scopeSelf($query)
    {
        return $query->where('user_id', user()->id);
    }
    public function scopePending($query)
    {
        return $query->where('booking_status', self::BOOKING_STATUS_PENDING);
    }

    public function scopeAccepted($query)
    {
        return $query->where('booking_status', self::BOOKING_STATUS_ACCEPTED);
    }

    public function scopeDeposited($query)
    {
        return $query->where('booking_status', self::BOOKING_STATUS_DEPOSITED);
    }

    public function scopeDelivered($query)
    {
        return $query->where('booking_status', self::BOOKING_STATUS_DELIVERED);
    }

    public function scopeReturned($query)
    {
        return $query->where('booking_status', self::BOOKING_STATUS_RETURNED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('booking_status', self::BOOKING_STATUS_CANCELLED);
    }

    public function scopeRejected($query)
    {
        return $query->where('booking_status', self::BOOKING_STATUS_REJECTED);
    }

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //
    public function humanReadableDateTime($row_date)
    {
        return Carbon::parse($row_date)->format('d M, Y h:i A');
    }

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */

    public function initials()
    {
        return $this->user ? substr($this->user->name, 0, 1) : null;
    }
}
