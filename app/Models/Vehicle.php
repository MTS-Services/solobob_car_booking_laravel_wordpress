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
        'sort_order',
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
        'weekly_rate',
        'monthly_rate',
        'security_deposit_weekly',
        'security_deposit_monthly',

        'transmission_type',

        'instant_booking',
        'delivery_available',
        'delivery_fee',
        'status',
        
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


    // Scope Availalbe

    public function scopeAvailable(Builder $query): Builder 
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }
    
    // Scope Rented

    public function scopeRented(Builder $query): Builder 
    {
        return $query->where('status', self::STATUS_RENTED);
    }

    // Scope Maintenance

    public function scopeMaintenance(Builder $query): Builder 
    {
        return $query->where('status', self::STATUS_MAINTENANCE);
    }

    // Scope Inactive

    public function scopeInactive(Builder $query): Builder 
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    // Scope Automatic

    public function scopeAutomatice(Builder $query): Builder 
    {
        return $query->where('transmission_type', self::transmission_type);
    }

    // Scope Manuall

    public function scopeManual(Builder $query): Builder 
    {
        return $query->where('transmission_type', self::TRANSMISSION_MANUAL);
    }


    //

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
