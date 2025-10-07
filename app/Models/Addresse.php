<?php

namespace App\Models;

use App\Models\BaseModel;

class Addresse extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */
    public const PERSONAL    = 0;
    public const RESIDENTIAL = 1;
    public const PARKING     = 2;


    public const TYPES = [
        0 => 'personal',
        1 => 'residential',
        2 => 'parking',
    ];

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'user_id',
        'address_type',
        'address',
        'city',
        'state',
        'postal_code',
        'is_default',
        'sort_order',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_default'   => 'boolean',
        'address_type' => 'integer',
    ];

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
