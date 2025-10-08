<?php

namespace App\Models;

use App\Models\BaseModel;

class Vehicle extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    public const STATUS_AVAILABLE = 0;
    public const STATUS_RENTED = 1;
    public const STATUS_MAINTENANCE = 2;
    public const STATUS_INACTIVE = 3;

    public const TRANSMISSION_AUTOMATIC = 0;
    public const TRANSMISSION_MANUAL = 1;


    public const STATUS = [
        self::STATUS_AVAILABLE => 'Abailable',
        self::STATUS_RENTED => 'Rented',
        self::STATUS_MAINTENANCE => 'Under Maintenance',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public static function getTransmission(): array
    {
        return [
            self::TRANSMISSION_AUTOMATIC => 'Automatic',
            self::TRANSMISSION_MANUAL => 'Manual',
        ];
    }

    public function getTransmissionLabelAttribute()
    {
        return isset($this->transmission_type) ? self::getTransmission()[$this->transmission_type] : 'Unknown';
    }

    public static function getStatus(): array
    {
        return [
            self::STATUS_AVAILABLE => 'Abailable',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_RENTED => 'Rented',
            self::STATUS_MAINTENANCE => 'Under Maintenance',
        ];
    }
    public function getStatusLabelAttribute()
    {
        return isset($this->status) ? self::getStatus()[$this->status] : 'Unknown';
    }

    public function getStatusColorAttribute()
    {
        return match ((int) $this->status) {
            self::STATUS_AVAILABLE => 'badge-success',
            self::STATUS_RENTED => 'badge-warning',
            self::STATUS_MAINTENANCE => 'badge-info',
            self::STATUS_INACTIVE => 'badge-danger',
            default => 'badge-secondary',
        };
    }

 

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'owner_id',
        'category_id',
        'title',
        'slug',
        'year',
        'color',
        'license_plate',
        'seating_capacity',
        'mileage',
        'description',
        'daily_rate',
        'weekly_rate',
        'transmission_type',
        'instant_booking',
        'delivery_available',
        'delivery_fee',
        'status',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'daily_rate' => 'decimal:2',
        'weekly_rate' => 'decimal:2',
        'monthly_rate' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'instant_booking' => 'boolean',
        'delivery_available' => 'boolean',
        'status' => 'integer',
        'approval_status' => 'integer',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
            'transmission_label',
        ]);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    //

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vehicle_id','id');
    }
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(VehicleImage::class, 'vehicle_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
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
