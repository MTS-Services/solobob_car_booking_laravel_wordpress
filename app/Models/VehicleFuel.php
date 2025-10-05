<?php

namespace App\Models;

use App\Models\BaseModel;

class VehicleFuel extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'name'
    ];

    protected $hidden = [];

    /**
     * Define the attribute casts for the model.
     */
    protected function casts(): array
    {
        return [];
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',            
            default => 'Unknown',
        };
    }
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'success',
            self::STATUS_INACTIVE => 'warning',            
            default => 'secondary',
        };
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    //

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }
    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
