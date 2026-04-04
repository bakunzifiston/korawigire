<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    protected $fillable = [
        'type',
        'title',
        'description',
        'price',
        'location',
        'contact_name',
        'contact_info',
        'status',
        'images',
        'details',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'details' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function primaryImage(): ?string
    {
        if (! is_array($this->images) || $this->images === []) {
            return null;
        }

        return $this->images[0] ?? null;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ListingComment::class)->latest();
    }
}
