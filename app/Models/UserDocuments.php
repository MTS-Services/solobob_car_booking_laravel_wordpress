<?php

namespace App\Models;

use App\Models\BaseModel;

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
        'licence',
        'selfe_licence',
        'address_proof',
        'issue_date',
        'expiry_date',
        'verification_status',
        'verified_at',
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
    public function getVerificationStatusLabelAttribute($value)
    {
        $status = [
            self::VERIFICATION_PENDING  => 'Pending',
            self::VERIFICATION_VERIFIED => 'Verified',
            self::VERIFICATION_REJECTED => 'Rejected',
        ];
        return $status[$this->verification_status];
    }
    public function getVerificationStatusColorAttribute()
    {
        $status = [
            self::VERIFICATION_PENDING  => 'warning',
            self::VERIFICATION_VERIFIED => 'success',
            self::VERIFICATION_REJECTED => 'danger',
        ];
        return $status[$this->verification_status];
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
