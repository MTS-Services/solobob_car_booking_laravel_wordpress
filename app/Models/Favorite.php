<?php

namespace App\Models;

use App\Models\BaseModel;

class Favorite extends BaseModel
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
        'user_id',
        'vehicle_id',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
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
