<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

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
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }



    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    //

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }
    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */
    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Active' : 'Inactive';
    }
    public function getStatusColorAttribute(): string
    {
        return $this->status ? 'badge-success' : 'badge-danger';
    }

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
