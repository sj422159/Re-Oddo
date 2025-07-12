<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'points',
        'is_admin',
        'avatar',
        'bio',
        'location',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function requestedSwaps()
    {
        return $this->hasMany(Swap::class, 'requester_id');
    }

    public function receivedSwaps()
    {
        return $this->hasMany(Swap::class, 'owner_id');
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function addPoints(int $points, string $description, $transactionable = null): void
    {
        $this->increment('points', $points);
        
        $this->pointTransactions()->create([
            'points' => $points,
            'type' => 'earned',
            'description' => $description,
            'transactionable_type' => $transactionable ? get_class($transactionable) : null,
            'transactionable_id' => $transactionable?->id,
        ]);
    }

    public function spendPoints(int $points, string $description, $transactionable = null): bool
    {
        if ($this->points < $points) {
            return false;
        }

        $this->decrement('points', $points);
        
        $this->pointTransactions()->create([
            'points' => -$points,
            'type' => 'spent',
            'description' => $description,
            'transactionable_type' => $transactionable ? get_class($transactionable) : null,
            'transactionable_id' => $transactionable?->id,
        ]);

        return true;
    }

    public function getItemsListedCountAttribute()
    {
        return $this->items()->where('status', 'approved')->count();
    }

    public function getSwapsMadeCountAttribute()
    {
        return $this->requestedSwaps()->where('status', 'completed')->count();
    }
}
