<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Addresse extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */
    public const PERSONAL    = 0;
    public const RESIDENTIAL = 1;
    public const PARKING     = 2;

    public const IS_DEFAULT = true;

    public const TYPES = [
        self::PERSONAL => 'personal',
        self::RESIDENTIAL => 'residential',
        self::PARKING => 'parking',
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

  


    /**
     * This scope for is_default
     * 
     */
    public function scopeIsdefault(Builder $query) : Builder 
    {
        return $query->where('is_default', self::IS_DEFAULT );
    }

     /**
     * This scope for USER
     * 
     */
    public function scopeSelf(Builder $query) : Builder 
    {
        return $query->where('user_id', user()->id);
    }

     /**
     * This scope for Adress Personal
     * 
     */
    public function scopePersonal(Builder $query) : Builder 
    {
        return $query->where('address_type', self::PERSONAL);
    }

  /**
     * This scope for Adress Residential
     * 
     */
    public function scopeResidential(Builder $query) : Builder 
    {
        return $query->where('address_type', self::RESIDENTIAL);
    }

     /**
     * This scope for Adress PARKING
     * 
     */
    public function scopeParking(Builder $query) : Builder 
    {
        return $query->where('address_type', self::PARKING);
    }


    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
