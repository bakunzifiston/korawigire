<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingComment extends Model
{
    protected $fillable = [
        'listing_id',
        'author_name',
        'author_contact',
        'body',
        'ip_address',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
}
