<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Swap extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_id',
        'owner_id',
        'item_id',
        'offered_item_id',
        'type',
        'points_used',
        'status',
        'message',
        'accepted_at',
        'completed_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function offeredItem()
    {
        return $this->belongsTo(Item::class, 'offered_item_id');
    }

    public function accept()
    {
        $this->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        $this->item->markAsSwapped();

        if ($this->type === 'points') {
            $this->owner->addPoints($this->points_used * 0.6, "Item swapped: {$this->item->title}", $this);
        }

        if ($this->offeredItem) {
            $this->offeredItem->markAsSwapped();
        }
    }

    public function complete()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
