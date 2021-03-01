<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
