<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; // Import for Scopes
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */

    // Role Constant
    public const ROLE_ADMIN = true;
    public const ROLE_USER = false;

    // Status Constand

    public const STATUS_ACTIVE = 1;
    public const STATUS_SUSPENDED = 2;
    public const STATUS_INACTIVE = 3;



    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */
    protected $fillable = [
        'sort_order',
        'name',
        'email',
        'password',
        'is_admin',
        'number',
        'last_login_at',
        'email_verified_at',
        'number_verified_at',
        'date_of_birth',
        'status',
        'avatar',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Define the attribute casts for the model.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * The accessors to append to the model's array form.
     */
    public $appends = [
        'status_label',
        'status_color',

        'created_at_human',
        'updated_at_human',
        'deleted_at_human',

        'created_at_formatted',
        'updated_at_formatted',
        'deleted_at_formatted',
    ];

    /* ================================================================
     * *** STATUS ***
     ================================================================ */


    public static function getStatus(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_SUSPENDED => 'Suspended',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return isset($this->status) ? self::getStatus()[$this->status] : 'Unknown';
    }

    public function getIsAdminLabelAttribute(): string
    {
        return $this->is_admin ? 'Administrator' : 'User';
    }

    public function getStatusColorAttribute(): string
    {
        return match ((int) $this->status) {
            self::STATUS_ACTIVE => 'badge-success',
            self::STATUS_SUSPENDED => 'badge-warning',
            self::STATUS_INACTIVE => 'badge-error',
            default => 'badge-secondary',
        };
    }
    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    public function addresses()
    {
        return $this->hasMany(Addresse::class, 'user_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'name');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->select('id', 'name');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by')->select('id', 'name');
    }



    /* ================================================================
     * *** SCOPES ***
     ================================================================ */
    public function scopeSelf(Builder $query):Builder
    {

        return $query->where('user_id', Auth::id());

    }
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('is_admin', self::ROLE_ADMIN);
    }
    public function scopeUser(Builder $query): Builder
    {
        return $query->where('is_admin', self::ROLE_USER);
    }
    public function scopeActive(Builder $query) : Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
    public function scopeSusepended(Builder $query) : Builder
    {
        return $query->where('status', self::STATUS_SUSPENDED);
    }
    public function scopeInactive(Builder $query) : Builder
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    /**
     * Accessor for human-readable 'created_at' time (e.g., "3 days ago").
     */
    public function getCreatedAtHumanAttribute(): string
    {
        return $this->created_at ? $this->created_at->diffForHumans() : 'Null';
    }

    public function getUpdatedAtHumanAttribute(): string
    {
        return $this->updated_at ? $this->updated_at->diffForHumans() : 'Null';
    }

    public function getDeletedAtHumanAttribute(): string
    {
        return $this->deleted_at ? $this->deleted_at->diffForHumans() : 'Null';
    }

    /**
     * Accessor for formatted 'created_at' date (e.g., "01 Jan, 2024 10:30 AM").
     */
    public function getCreatedAtFormattedAttribute(): string
    {
        return Carbon::parse($this->created_at)->format('d M, Y h:i A');
    }

    /**
     * Accessor for formatted 'updated_at' date.
     */
    public function getUpdatedAtFormattedAttribute(): string
    {
        return Carbon::parse($this->updated_at)->format('d M, Y h:i A');
    }

    /**
     * Accessor for formatted 'deleted_at' date.
     */
    public function getDeletedAtFormattedAttribute(): string
    {
        return Carbon::parse($this->deleted_at)->format('d M, Y h:i A');
    }

    /* ================================================================
     * *** UTILITY METHODS ***
     * Custom methods for model logic that don't fall into other categories.
     ================================================================ */

    /**
     * Generates and returns the user's initials (e.g., "John Doe" -> "JD").
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Checks if the user has the administrator role.
     * This is the preferred way to check permissions outside of query scopes.
     */
    public function isAdmin(): bool
    {
        // Since is_admin is cast to boolean, this is a clean check against the constant.
        return $this->is_admin === self::ROLE_ADMIN;
    }
}
