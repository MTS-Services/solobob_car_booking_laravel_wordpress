<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class VehicleImage extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    // public const ACTIVE = 1;
    // public const INACTIVE = 0;

    public const IS_PRIMARY = true;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',
        'vehicle_id',
        'image',
        'is_primary',
    
        'created_by',
        'updated_by',
        'deleted_by',
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
        $this->appends = array_merge(parent::getAppends(), []);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */
    
    // Is Primary

    public function scopeIsPrimary(Builder $query): Builder
    {
        return $query->where('is_primary', self::IS_PRIMARY );
    }

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
