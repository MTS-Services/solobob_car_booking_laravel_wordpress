<?php

namespace App\Models;

use App\Models\BaseModel;
use Carbon\Carbon;

class Booking extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */
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
        'pickup_date',          // DateTime (combined date + time)
        'return_date',          // DateTime (combined date + time)
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
        'created_by',
        'updated_by',
        'deleted_by',
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
        $this->appends = array_merge(parent::getAppends(), [
            'booking_status_label',
            'booking_status_color',
            'rental_duration_days',
        ]);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pickupLocation()
    {
        return $this->belongsTo(VehicleLocation::class, 'pickup_location_id', 'id');
    }

    public function auditor()
    {
        return $this->belongsTo(User::class, 'audit_by', 'id');
    }

    public function timeline()
    {
        return $this->hasMany(BookingStatusTimeline::class, 'booking_id', 'id');
    }

    public function rentalCheckin()
    {
        return $this->hasMany(RentalCheckin::class, 'booking_id', 'id');
    }

    public function rentalCheckout()
    {
        return $this->hasMany(Rentalcheckout::class, 'booking_id', 'id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'booking_id', 'id');
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'booking_id', 'id');
    }

    // === NEW RELATIONS ===
    
    /**
     * Get booking relation data (if using booking_relations table)
     */
    public function relation()
    {
        return $this->hasOne(BookingRelation::class, 'booking_id', 'id');
    }

    /**
     * Get billing information through relation
     */
    public function billingInformation()
    {
        return $this->hasOneThrough(
            BillingInformation::class,
            BookingRelation::class,
            'booking_id',              // Foreign key on booking_relations
            'id',                      // Foreign key on billing_informations
            'id',                      // Local key on bookings
            'billing_information_id'   // Local key on booking_relations
        );
    }

    /**
     * Get residential address through relation
     */
    public function residentialAddress()
    {
        return $this->hasOneThrough(
            Addresse::class,
            BookingRelation::class,
            'booking_id',
            'id',
            'id',
            'residential_address_id'
        );
    }

    /**
     * Get parking address through relation
     */
    public function parkingAddress()
    {
        return $this->hasOneThrough(
            Addresse::class,
            BookingRelation::class,
            'booking_id',
            'id',
            'id',
            'parking_address_id'
        );
    }

    /**
     * Get user documents through relation
     */
    public function userDocument()
    {
        return $this->hasOneThrough(
            UserDocuments::class,
            BookingRelation::class,
            'booking_id',
            'id',
            'id',
            'user_document_id'
        );
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
    public function getBookingStatusLabelAttribute()
    {
        return match ($this->attributes['booking_status']) {
            self::BOOKING_STATUS_PENDING => 'Pending',
            self::BOOKING_STATUS_ACCEPTED => 'Accepted',
            self::BOOKING_STATUS_DEPOSITED => 'Deposited',
            self::BOOKING_STATUS_DELIVERED => 'Delivered',
            self::BOOKING_STATUS_RETURNED => 'Returned',
            self::BOOKING_STATUS_CANCELLED => 'Cancelled',
            self::BOOKING_STATUS_REJECTED => 'Rejected',
            default => 'Unknown',
        };
    }

    public function getBookingStatusColorAttribute()
    {
        return match ((int)$this->booking_status) {
            self::BOOKING_STATUS_PENDING => 'badge-secondary',
            self::BOOKING_STATUS_ACCEPTED => 'badge-info',
            self::BOOKING_STATUS_DEPOSITED => 'badge-info',
            self::BOOKING_STATUS_DELIVERED => 'badge-success',
            self::BOOKING_STATUS_RETURNED => 'badge-warning',
            self::BOOKING_STATUS_CANCELLED => 'badge-warning',
            self::BOOKING_STATUS_REJECTED => 'badge-error',
            default => 'badge-secondary',
        };
    }

    public function getRentalDurationDaysAttribute()
    {
        if ($this->pickup_date && $this->return_date) {
            return Carbon::parse($this->pickup_date)->diffInDays(Carbon::parse($this->return_date));
        }
        return 0;
    }

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

    /**
     * Generate unique booking reference
     */
    public static function generateBookingReference(): string
    {
        do {
            $reference = 'BK-' . strtoupper(uniqid());
        } while (self::where('booking_reference', $reference)->exists());

        return $reference;
    }
}