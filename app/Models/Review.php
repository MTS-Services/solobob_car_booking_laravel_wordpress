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
        $this->appends = array_merge(parent::getAppends(), [
            'review_status_label',
            'review_status_color',
        ]);
    }

    /* ================================================================
     * *** ATTRIBUTES ***
     ================================================================ */
    public function getReviewStatusLabelAttribute()
    {
        return match ($this->review_status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_FLAGGED => 'Flagged',
            self::STATUS_REMOVED => 'Removed',
            default => 'Unknown',
        };
    }
    public function getReviewStatusColorAttribute()
    {
        return match ($this->review_status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_PUBLISHED => 'success',
            self::STATUS_FLAGGED => 'danger',
            self::STATUS_REMOVED => 'danger',
            default => 'warning',
        };
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
    public function scopeSelf($query)
    {
        return $query->where('user_id', user()->id);
    }
    public function scopePending($query)
    {
        return $query->where('review_status', self::STATUS_PENDING);
    }
    public function scopeFlagged($query)
    {
        return $query->where('review_status', self::STATUS_FLAGGED);
    }
     public function scopePublished($query)
    {
        return $query->where('review_status', self::STATUS_PUBLISHED);
    }
    public function scopeRemoved($query)
    {
        return $query->where('review_status', self::STATUS_REMOVED);
    }

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    //

    /* ================================================================
     * *** UTILITY METHODS ***
     ================================================================ */
}
