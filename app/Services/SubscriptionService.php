<?php

namespace App\Services;

use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use App\Services\Thirdparties\GoogleVerifySubscription;

class SubscriptionService
{
    private $subscriptionRepository;
    public function __construct(SubscriptionRepository $subscriptionRepository, GoogleVerifySubscription $googleVerifySubscription)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }
    public function expiredSubscriptions()
    {
       return $this->subscriptionRepository->getExpiredSubscriptions();
    }

    public function updateExpiration(Subscription $subscription)
    {
        $this->subscriptionRepository->updateExpiration($subscription);
    }

    public function createSubscription($data)
    {
        return $this->subscriptionRepository->create($data);
    }
}

