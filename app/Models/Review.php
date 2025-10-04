<?php

namespace App\Models;

use App\Models\BaseModel;

class Review extends BaseModel
{
    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */
    const STATUS_PENDING   = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_FLAGGED   = 2;
    const STATUS_REMOVED   = 3;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $fillable = [
        'sort_order',
        'booking_id',
        'user_id',
        'rating',
        'title',
        'comment',
        'review_status',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), []);
    }

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */
    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

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
