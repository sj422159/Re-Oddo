<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'size',
        'condition',
        'type',
        'tags',
        'images',
        'status',
        'is_available',
        'point_value',
    ];

    protected $casts = [
        'tags' => 'array',
        'images' => 'array',
        'is_available' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function swaps()
    {
        return $this->hasMany(Swap::class);
    }

    public function scopeApproved(Builder $query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeAvailable(Builder $query)
    {
        return $query->where('is_available', true);
    }

    public function scopePending(Builder $query)
    {
        return $query->where('status', 'pending');
    }

    public function getFirstImageAttribute()
    {
        return $this->images[0] ?? '/images/placeholder-item.jpg';
    }

    public function getTagsStringAttribute()
    {
        return implode(', ', $this->tags ?? []);
    }

    public function markAsSwapped()
    {
        $this->update(['is_available' => false]);
    }
}
