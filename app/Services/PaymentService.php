<?php

namespace App\Services;

use App\Enums\DeviceEnum;
use App\Repositories\DeviceRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    protected $paymentRepository;
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }
    public function createPayment(array $data)
    {
        return $this->paymentRepository->create($data);
    }

    public function verifyPayment(Request $request)
    {
         if($request->user()->os === DeviceEnum::IOS)
            $url = config('services.apple.base_url') . 'verify';
        if($request->user()->os === DeviceEnum::GOOGLE)
            $url = config('services.google.base_url') . 'verify';

        return Http::post($url, [
            'receipt'=>$request->receipt
        ]);
    }
}
