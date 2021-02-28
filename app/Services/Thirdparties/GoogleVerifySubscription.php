<?php

namespace App\Services\Thirdparties;

use App\Models\Subscription;

class GoogleVerifySubscription implements ThirdpartyInterface{

    private $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
    public function run(){
        
    }
}
