<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class UserDocuments extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */
    public const VERIFICATION_PENDING  = 0;
    public const VERIFICATION_VERIFIED = 1;
    public const VERIFICATION_REJECTED = 2;


    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'user_id',
        'sort_order',
        'licence',
        'selfe_licence',
        'address_proof',
        'issue_date',
        'expiry_date',
        'verification_status',
        'verified_at',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'datetime',
        'verified_at' => 'datetime',
        'verification_status' => 'integer',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'verification_status_label',
            'verification_status_color',    
        ]);
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

    // Scope for Only this user's

    public function scopeSelf(Builder $query): Builder
    {
        return $query->where('user_id', user()->id);
    }

    // Scope for Only this pending Verification


    public function scopePending(Builder $query): Builder
    {
        return $query->where('verification_status', self::VERIFICATION_PENDING);
    }

    // Scope for Only this pending Verification

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('verification_status', self::VERIFICATION_VERIFIED);
    }

    // Scope for Only this pending Verification
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('verification_status', self::VERIFICATION_REJECTED);
    }


    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */


    public static function getVerificationStatus(): array
    {
        return [
            self::VERIFICATION_PENDING  => 'Pending',
            self::VERIFICATION_VERIFIED => 'Verified',
            self::VERIFICATION_REJECTED => 'Rejected',
        ];
    }
    public static function getVerificationStatusColor(): array
    {
        return [
            self::VERIFICATION_PENDING  => 'badge-warning',
            self::VERIFICATION_VERIFIED => 'badge-success',
            self::VERIFICATION_REJECTED => 'badge-danger',
        ];
    }

    public function getVerificationStatusLabelAttribute(): string
    {

        return self::getVerificationStatus()[$this->verification_status] ?? 'N/A';
    }

    public function getVerificationStatusColorAttribute(): string
    {
        
        return self::getVerificationStatusColor()[$this->verification_status] ?? 'badge-secondary';
    }


    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
