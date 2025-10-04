<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Category extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

 

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), []);
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
        return self::getStatus()[$this->status] ?? 'Unknown';
    }
    public function getIsCategoryLabelAttribute(): string
    {
        return $this->is_admin ? 'Administrator' : 'User';
    }
    public function getStatusColorAttribute(): string
    {
         return match ($this->status) {
            self::STATUS_ACTIVE => 'success',
            self::STATUS_INACTIVE => 'warning',
            default => 'secondary',
        };
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
