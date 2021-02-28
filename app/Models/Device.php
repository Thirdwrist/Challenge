<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Device extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $guarded = [];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
