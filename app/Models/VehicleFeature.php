<?php

namespace App\Models;

use App\Models\BaseModel;

class VehicleFeature extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    public const FEATURE_CATEGORY_SAFETY        = 1;
    public const FEATURE_CATEGORY_COMFORT       = 2;
    public const FEATURE_CATEGORY_ENTERTAINMENT = 3;
    public const FEATURE_CATEGORY_OTHER         = 4;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
       'name',
       'slug',
       'icon',
       'feature_category',
    ];

    protected $hidden = [
        
    ];

    /**
     * Define the attribute casts for the model.
     */
    protected function casts(): array
    {
        return [
            
        ];
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            
        ]);
    }

     /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    //

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
