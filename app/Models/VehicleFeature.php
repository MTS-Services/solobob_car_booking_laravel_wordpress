<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class VehicleFeature extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    public const FEATURE_CATEGORY_SAFETY        = 1;
    public const FEATURE_CATEGORY_COMFORT       = 2;
    public const FEATURE_CATEGORY_ENTERTAINMENT = 3;
    public const FEATURE_CATEGORY_OTHER         = 4;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'feture_category_label',
            'feture_category_color',
        ]);
    }

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',
        'name',
        'slug',
        'icon',
        'feature_category',

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



    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    //

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    public function scopeCategorySafety(Builder $query): Builder
    {
        return $query->where('feature_category', self::FEATURE_CATEGORY_SAFETY);
    }

    public function scopeCategoryComfort(Builder $query): Builder
    {
        return $query->where('feature_category', self::FEATURE_CATEGORY_COMFORT);
    }

    public function scopeCategoryEntertainment(Builder $query): Builder
    {
        return $query->where('feature_category', self::FEATURE_CATEGORY_ENTERTAINMENT);
    }

    public function scopeCategoryOther(Builder $query): Builder
    {
        return $query->where('feature_category', self::FEATURE_CATEGORY_OTHER);
    }


    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    public function getFetureCategoryLabelAttribute()
    {
        return match ($this->feature_category) {
            self::FEATURE_CATEGORY_SAFETY => 'Safety',
            self::FEATURE_CATEGORY_COMFORT => 'Comfort',
            self::FEATURE_CATEGORY_ENTERTAINMENT => 'Entertainment',
            self::FEATURE_CATEGORY_OTHER => 'Other',
            default => 'Unknown',
        };
    }
    public function getFetureCategoryColorAttribute()
    {
        return match ($this->feature_category) {
            self::FEATURE_CATEGORY_SAFETY => 'danger',
            self::FEATURE_CATEGORY_COMFORT => 'success',
            self::FEATURE_CATEGORY_ENTERTAINMENT => 'warning',
            self::FEATURE_CATEGORY_OTHER => 'secondary',
            default => 'secondary',
        };
    }


    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
