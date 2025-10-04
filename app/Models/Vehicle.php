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

    // public const APPROVAL_PENDING = 0;
    // public const APPROVAL_APPROVED = 1;
    // public const APPROVAL_REJECTED = 2;

    public const STATUS = [
        self::STATUS_AVAILABLE => 'Available',
        self::STATUS_RENTED => 'Rented',
        self::STATUS_MAINTENANCE => 'Under Maintenance',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    // public const APPROVAL_STATUS = [
    //     self::APPROVAL_PENDING => 'Pending',
    //     self::APPROVAL_APPROVED => 'Approved',
    //     self::APPROVAL_REJECTED => 'Rejected',
    // ];
    public static function getStatus(): array
    {
        return [
            self::STATUS_AVAILABLE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }
    // public static function getApprovalStatus(): array
    // {
    //     return [
    //         self::APPROVAL_PENDING => 'Active',
    //         self::APPROVAL_APPROVED => 'Inactive',
    //     ];
    // }
    public function getStatusLabelAttribute()
    {
        return self::STATUS[$this->status] ?? 'Unknown';
    }

    // public function getApprovalStatusLabelAttribute()
    // {
    //     return self::APPROVAL_STATUS[$this->approval_status] ?? 'Unknown';
    // }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE => 'success',
            self::STATUS_RENTED => 'warning',
            self::STATUS_MAINTENANCE => 'info',
            self::STATUS_INACTIVE => 'danger',
            default => 'secondary',
        };
    }

    // public function getApprovalStatusColorAttribute()
    // {
    //     return match ($this->approval_status) {
    //         self::APPROVAL_PENDING => 'warning',
    //         self::APPROVAL_APPROVED => 'success',
    //         self::APPROVAL_REJECTED => 'danger',
    //         default => 'secondary',
    //     };
    // }

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
        'vin',
        'seating_capacity',
        'mileage',
        'description',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'security_deposit',
        'minimum_rental_days',
        'maximum_rental_days',
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
        'security_deposit' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'instant_booking' => 'boolean',
        'delivery_available' => 'boolean',
        'status' => 'integer',
        'approval_status' => 'integer',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), []);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    //

    public function owner()
    {
        return $this->belongsTo(User::class);
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
