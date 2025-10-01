<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder; // Import for Scopes

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /* ================================================================
     * *** MODEL CONSTANTS ***
     ================================================================ */
    public const ROLE_ADMIN = true;
    public const ROLE_USER = false;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
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
        'created_at_human',
        'updated_at_human',
        'created_at_formatted',
        'updated_at_formatted',
    ];


    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */

    //

    /* ================================================================
     * *** SCOPES ***
     ================================================================ */

    /**
     * Scope a query to include only admin users (is_admin = true).
     */
    public function scopeAdmins(Builder $query): void
    {
        $query->where('is_admin', self::ROLE_ADMIN);
    }

    /**
     * Scope a query to include only basic/non-admin users (is_admin = false).
     */
    public function scopeUsers(Builder $query): void
    {
        $query->where('is_admin', self::ROLE_USER);
    }


    /* ================================================================
     * *** ACCESSORS ***
     ================================================================ */

    /**
     * Accessor for human-readable 'created_at' time (e.g., "3 days ago").
     */
    public function getCreatedAtHumanAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Accessor for human-readable 'updated_at' time.
     */
    public function getUpdatedAtHumanAttribute(): string
    {
        return $this->updated_at->diffForHumans();
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
            ->map(fn($word) => Str::substr($word, 0, 1))
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
