<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'prompts_remaining',
        'is_premium',
        'is_admin',
        'avatar',
        'subscription_expires_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_premium' => 'boolean',
        'is_admin' => 'boolean',
        'subscription_expires_at' => 'datetime',
    ];

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function hasPromptsRemaining()
    {
        return $this->prompts_remaining > 0;
    }

    public function decrementPrompts()
    {
        if ($this->prompts_remaining > 0) {
            $this->decrement('prompts_remaining');
        }
    }

    public function hasValidSubscription()
    {
        return $this->is_premium && 
               $this->subscription_expires_at && 
               $this->subscription_expires_at->isFuture();
    }

    public function subscribe()
    {
        $this->update([
            'is_premium' => true,
            'prompts_remaining' => 100,
            'subscription_expires_at' => Carbon::now()->addDays(30)
        ]);
    }

    public function checkAndUpdateSubscription()
    {
        if ($this->subscription_expires_at && $this->subscription_expires_at->isPast()) {
            $this->update([
                'is_premium' => false,
                'prompts_remaining' => 10,
                'subscription_expires_at' => null
            ]);
        }
    }
}
