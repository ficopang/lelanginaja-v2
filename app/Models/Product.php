<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['total_bid_amount'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function getTotalBidAmountAttribute($id = null)
    {
        if ($id !== null) {
            $totalBidAmount = $this->bids()->where('id', '<=', $id)->sum('bid_amount');
        } else {
            $totalBidAmount = $this->bids()->sum('bid_amount');
        }

        return $totalBidAmount + $this->starting_price;
    }

    public function getTotalBidAmountUser($userId, $id = null)
    {
        if ($id !== null && $userId !== null) {
            $totalBidAmount = $this->bids()->where('user_id', '<=', $userId)->where('id', '<=', $id)->sum('bid_amount');
        } else {
            $totalBidAmount = $this->bids()->where('user_id', '<=', $userId)->sum('bid_amount');
        }

        return $totalBidAmount + $this->starting_price;
    }

    public function undiscountedPrice()
    {
        return $this->starting_price * 2;
    }

    public function lastbid()
    {
        return $this->bids()->latest('created_at')->first();
    }

    public function reports(): HasMany
    {
        return $this->hasMany(ProductReport::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }
}
