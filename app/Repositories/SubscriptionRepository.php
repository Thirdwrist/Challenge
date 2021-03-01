<?php

namespace  App\Repositories;

use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class SubscriptionRepository {


    public function getExpiredSubscriptions()
    {
        return Subscription::whereDate('expires_on', '<', now())
                ->where('expired', false)
                ->sharedLock()
                ->get();
    }

    public function updateExpiration(Subscription $subscription)
    {
        DB::transaction(function () use($subscription){
            $subscription->lockForUpdate();
            $subscription->expired = true;
            $subscription->save();
        });
    }

    public function create($data)
    {

        DB::transaction(function () use($data, &$subscription){
            $subscription = Subscription::create([
                'payment_id'=>$data['payment_id'],
                'expires_on'=>$data['expires_on'],
                'device_id'=>$data['device_id'],
            ]);
        });

        return $subscription;
    }
}
