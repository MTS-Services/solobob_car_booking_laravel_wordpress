<?php

namespace App\Models;

use App\Models\BaseModel;

class Review extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    /** ENUMs */
    public const TYPE_RENTER_TO_OWNER  = 1;
    public const TYPE_OWNER_TO_RENTER  = 2;
    public const TYPE_VEHICLE_REVIEW   = 3;

    public const STATUS_PENDING   = 0;
    public const STATUS_PUBLISHED = 1;
    public const STATUS_FLAGGED   = 2;
    public const STATUS_REMOVED   = 3;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'booking_id',
        'reviewer_id',
        'reviewee_id',
        'review_type',
        'rating',
        'title',
        'comment',
        'cleanliness_rating',
        'communication_rating',
        'vehicle_accuracy_rating',
        'value_rating',
        'response',
        'response_date',
        'is_featured',
        'review_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'response_date' => 'datetime',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), []);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
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
