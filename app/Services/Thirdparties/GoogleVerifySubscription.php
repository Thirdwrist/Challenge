<?php

namespace App\Services\Thirdparties;

use App\Models\Subscription;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class GoogleVerifySubscription implements ThirdpartyInterface{

    private $subscription;
    public function setSubscription(Subscription $subscription)
    {
        $this->subscription = $subscription;
        return $this;
    }

    public function run(){
       return Http::post(config('services.google.base_url').'subscription/verify', [
           'receipt'=>$this->subscription->payment->receipt
       ]);
    }
}
