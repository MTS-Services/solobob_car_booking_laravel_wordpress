<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class Addresse extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */
    public const PERSONAL    = 0;
    public const RESIDENTIAL = 1;
    public const PARKING     = 2;

    public const IS_DEFAULT = true;

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
        $this->appends = array_merge(parent::getAppends(), [
            'default_label',
            'default_color',
            'address_type_lable',
            'address_type_color',
        ]);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function paymentMethoad()
    {
        return $this->hasMany(PaymentMethod::class, 'id', 'billing_address_id');
    }

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */


    public function scopeIsdefault(Builder $query): Builder
    {
        return $query->where('is_default', self::IS_DEFAULT);
    }

    public function scopeSelf(Builder $query): Builder
    {
        return $query->where('user_id', user()->id);
    }

    public function scopePersonal(Builder $query): Builder
    {
        return $query->where('address_type', self::PERSONAL);
    }

    public function scopeResidential(Builder $query): Builder
    {
        return $query->where('address_type', self::RESIDENTIAL);
    }

    public function scopeParking(Builder $query): Builder
    {
        return $query->where('address_type', self::PARKING);
    }

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    public function getDefaultLabelAttribute(): string
    {
        return $this->is_default ? 'Default' : 'Not Default';
    }

    public function getDefaultColorAttribute(): string
    {
        return $this->is_default ? 'badge-success' : 'badge-warning';
    }



    public static function getAddressType(): array
    {
        return [
            self::PERSONAL => 'personal',
            self::RESIDENTIAL => 'residential',
            self::PARKING => 'parking',
        ];
    }

    public static function getAddressColor(): array
    {
        return [
            self::PERSONAL => 'badge-primary',
            self::RESIDENTIAL => 'badge-accent',
            self::PARKING => 'badge-neutral',
        ];
    }

    public function getAddressTypeLableAttribute(): string
    {
        return self::getAddressType()[$this->address_type] ?? "Unknown";
    }

    public function getAddressTypeColorAttribute(): string
    {
        return self::getAddressColor()[$this->address_type] ?? "badge-warning";
    }




    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
