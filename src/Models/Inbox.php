<?php

namespace YourVendor\FakeInbox\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Fake Inbox model representing a virtual email inbox.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property array $settings
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\YourVendor\FakeInbox\Models\InboxEmail[] $emails
 * @property-read \App\Models\User $user
 */
class Inbox extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'settings', 'user_id'];
    protected $casts = ['settings' => 'array'];

    /**
     * Relationship with InboxEmail models.
     *
     * @return HasMany
     */
    public function emails(): HasMany
    {
        return $this->hasMany(InboxEmail::class);
    }

    /**
     * Relationship with the User model.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Generate a unique slug for the inbox.
     *
     * @param string $name
     * @return string
     */
    public static function generateSlug(string $name): string
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'like', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
}