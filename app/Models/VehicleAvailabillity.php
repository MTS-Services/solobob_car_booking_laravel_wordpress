<?php

namespace App\Models;

use App\Models\BaseModel;

class VehicleAvailabillity extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    //  [note: "'booked', 'maintenance', 'owner_blocked'"]
    public const REASON_BOOKED          = 1;
    public const REASON_MAINTENANCE     = 2;
    public const REASON_OWNER_BLOCKED   = 3;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'vehicle_id',
        'unavailable_date',
        'reason',
        'created_by',
        'updated_by',
        'deleted_by',
       
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
