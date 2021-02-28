<?php

namespace App\Services;

use App\Repositories\SubscriptionRepository;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionService
{
    private $subscriptionRepository;
    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }
    public function expiredSubscriptions()
    {
       return $this->subscriptionRepository->getExpiredSubscriptions();
    }

    public function verifySubscriptions(Collection $subscriptions)
    {
        
    }
}

