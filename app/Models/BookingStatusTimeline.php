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
        $this->appends = array_merge(parent::getAppends(), []);
    }



    // Helper method
    public function getStatusLabelAttribute(): string
    {
        return match ($this->booking_status) {
            self::STATUS_PENDING    => 'Pending',
            self::STATUS_ACCEPTED   => 'Accepted',
            self::STATUS_DEPOSITED  => 'Deposited',
            self::STATUS_DELIVERED  => 'Delivered',
            self::STATUS_RETURNED   => 'Returned',
            self::STATUS_CANCELLED  => 'Cancelled',
            self::STATUS_REJECTED   => 'Rejected',
            default => 'Unknown',
        };
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    public function booking()
    {
        return $this->belongsTo(Booking::class);
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
