<?php

namespace App\Models;

use App\Models\BaseModel;

class BookingStatusTimeline extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */
    public const STATUS_PENDING    = 0;
    public const STATUS_ACCEPTED   = 1;
    public const STATUS_DEPOSITED  = 2;
    public const STATUS_DELIVERED  = 3;
    public const STATUS_RETURNED   = 4;
    public const STATUS_CANCELLED  = 5;
    public const STATUS_REJECTED   = 6;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',
        'booking_id',
        'booking_status',

        'created_by',
        'updated_by',
        'deleted_by',
    ];
    /**
     * Define the attribute casts for the model.
     */

    protected $casts = [
        'booking_status' => 'integer',
    ];





    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'staus_label',
            'staus_color',
        ]);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    public function scopePending($query)
    {
        return $query->where('booking_status', self::STATUS_PENDING);
    }
    public function scopeAccepted($query)
    {
        return $query->where('booking_status', self::STATUS_ACCEPTED);
    }
    public function scopeDeposited($query)
    {
        return $query->where('booking_status', self::STATUS_DEPOSITED);
    }
    public function scopeDelivered($query)
    {
        return $query->where('booking_status', self::STATUS_DELIVERED);
    }
    public function scopeReturned($query)
    {
        return $query->where('booking_status', self::STATUS_RETURNED);
    }
    public function scopeCancelled($query)
    {
        return $query->where('booking_status', self::STATUS_CANCELLED);
    }
    public function scopeRejected($query)
    {
        return $query->where('booking_status', self::STATUS_REJECTED);
    }


    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    public function getStatus(): array
    {
        return [
            self::STATUS_PENDING    => 'Pending',
            self::STATUS_ACCEPTED   => 'Accepted',
            self::STATUS_DEPOSITED  => 'Deposited',
            self::STATUS_DELIVERED  => 'Delivered',
            self::STATUS_RETURNED   => 'Returned',
            self::STATUS_CANCELLED  => 'Cancelled',
            self::STATUS_REJECTED   => 'Rejected',
        ];
    }

    // Helper method
    public function getStatusLabelAttribute(): string
    {
        return isset($this->status) ? self::getStatus()[$this->status] : 'Unknown';
    }


    public function getStatusColorAttribute()
    {
        return match ((int)$this->booking_status) {
            self::STATUS_PENDING => 'badge-warning',
            self::STATUS_ACCEPTED => 'badge-primary',
            self::STATUS_DEPOSITED => 'badge-info',
            self::STATUS_DELIVERED => 'badge-success',
            self::STATUS_RETURNED => 'badge-secondary',
            self::STATUS_CANCELLED => 'badge-dark',
            self::STATUS_REJECTED => 'badge-danger',
            default => 'badge-light',
        };
    }

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
