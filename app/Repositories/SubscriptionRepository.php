<?php

namespace  App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository {


    public function getExpiredSubscriptions()
    {
        return Subscription::whereDay('expires_on', '<=', now())
            ->get();
    }
}
