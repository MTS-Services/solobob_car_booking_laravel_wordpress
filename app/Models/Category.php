<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class Category extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */



    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',  
        'parent_id',
        'name',
        'slug',
        'status',

        'created_by',
        'updated_by',
        'deleted_by',

    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }

    /* ================================================================
     * *** Status ***
     ================================================================ */

    //

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;


    public static function getStatus(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }
    public function getStatusLabelAttribute(): string
    {
        return isset($this->status) ? self::getStatus()[$this->status] : 'Unknown';
    }

    // public function getStatusLabelAttribute(): string
    // {
    //     return self::getStatus()[$this->status] ?? 'Unknown';
    // }


    public function getIsCategoryLabelAttribute(): string
    {
        return $this->is_admin ? 'Administrator' : 'User';
    }
    public function getStatusColorAttribute(): string
    {
        return match ((int) $this->status) {
            self::STATUS_ACTIVE => 'badge-success',
            self::STATUS_INACTIVE => 'badge-warning',
            default => 'badge-secondary',
        };
    }
    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    //
    public function scopeActive(Builder $query): Builder
    {
      return  $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
      return  $query->where('status', self::STATUS_INACTIVE);
    }

    

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
