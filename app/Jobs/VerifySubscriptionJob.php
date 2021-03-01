<?php

namespace App\Jobs;

use App\Enums\DeviceEnum;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use App\Services\Thirdparties\GoogleVerifySubscription;
use App\Services\Thirdparties\IOSVerifySubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Response;

class VerifySubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $subscription;
    public $tries = 5;
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }


    public function middleware()
    {
        return [new WithoutOverlapping($this->subscription->id)];
    }

    public function handle(IOSVerifySubscription $iosVerifySubscription,  GoogleVerifySubscription $googleVerifySubscription, SubscriptionService $subService)
    {
        $res = $this->dispatchVerifyJob($iosVerifySubscription, $googleVerifySubscription);
        $this->checkResponse($res, $subService);

    }

    private function dispatchVerifyJob($iosVerifySubscription, $googleVerifySubscription)
    {
        if($this->subscription->device->os === DeviceEnum::IOS)
        {
            return $iosVerifySubscription
                ->setSubscription($this->subscription)
                ->run();
        }
        if($this->subscription->device->os === DeviceEnum::GOOGLE)
        {
            return $googleVerifySubscription
                ->setSubscription($this->subscription)
                ->run();
        }

        $this->fail();
    }

    private function checkResponse($res, $subService)
    {
        if($res->status() === Response::HTTP_OK)
        {

            $data = $res->json();
            if($res['data']['subscription']['status'] == false)
            {
                $subService->updateExpiration($this->subscription);
            }

            if($data['status'] ==='limited')
            {
                $this->fail();
            }
        }

        if($res->status() === Response::HTTP_BAD_REQUEST || $res->status() === Response::HTTP_INTERNAL_SERVER_ERROR)
        {
            $this->fail();
        }
    }
}
