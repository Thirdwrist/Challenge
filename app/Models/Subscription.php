<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function payment(){
        return $this->belongsTo(Payment::class);
    }
}
