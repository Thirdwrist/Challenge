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

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
