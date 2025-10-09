<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class VehicleModel extends BaseModel
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
        'name',
        'sort_order',
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

    public function vehicleRelation()
    {
        return $this->hasMany(VehicleRelation::class, 'model_id', 'id');
    }

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive(Builder $query):Builder
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

     public static function getStatuses(): array
     {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
     }
    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }
    public function getStatusColorAttribute()
    {
        return $this->status ? 'badge-success' : 'badge-warning';
    }

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
