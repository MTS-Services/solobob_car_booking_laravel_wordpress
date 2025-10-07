<?php

namespace App\Models;

use App\Models\BaseModel;

class VehicleMake extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    public const ACTIVE = 1;
    public const INACTIVE = 0;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',
        'name',
        'status',

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

    //

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    //Scope for Active

    public function scopeActive(Builder $query):Builder 
    {
        return $query->where('status', SELF::ACTIVE);
    }

    //Scope for Inactive

    public function scopeInActive(Builder $query):Builder 
    {
        return $query->where('status', SELF::INACTIVE);
    }

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
