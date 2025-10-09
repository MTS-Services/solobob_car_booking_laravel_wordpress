<?php

namespace App\Models;

use App\Models\BaseModel;

class VehicleRelation extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    // public const ACTIVE = 1;
    // public const INACTIVE = 0;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',
        'vehicle_id',
        'feature_id',
        'make_id',
        'model_id',
        
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

    public function feature()
    {
        return $this->belongsTo(VehicleFeature::class);
    }

    public function make()
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function model()
    {
        return $this->belongsTo(VehicleModel::class);
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
