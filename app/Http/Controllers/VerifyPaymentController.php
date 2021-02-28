<?php

namespace App\Http\Controllers;

use App\Enums\DeviceEnum;
use App\Http\Controllers\Traits\RequestTrait;
use App\Models\Payment;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyPaymentController extends Controller
{
    use RequestTrait;

    public function verify(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'receipt'=>['required', 'integer'],
        ]);
        if($validate->fails())
        {
           throw new ValidationException($validate);
        }

        if($request->user()->os === DeviceEnum::IOS)
            $url = config('services.apple.base_url') . 'verify';
        if($request->user()->os === DeviceEnum::GOOGLE)
            $url = config('services.google.base_url') . 'verify';

        $res = Http::post($url, [
            'receipt'=>$request->receipt
        ]);

        $payment = Payment::create([
                'device_id'=>$request->user()->id,
                'receipt'=> $request->receipt,
                'status'=> $res->json()['status']
        ]);

        if($res->status() === Response::HTTP_OK)
        {
            Subscription::create([
                'payment_id'=> $payment->id,
                'expires_on'=>$this->changeToServerTimeZone($res->json()['expires_on'], config('services.apple.timezone')),
                'device_id'=>$request->user()->id
            ]);

            return $this->response(Response::HTTP_OK);
        }
        if($res->status() === Response::HTTP_BAD_REQUEST)
            return $this->response(Response::HTTP_OK,[], 'invalid');
    }

    private function changeToServerTimeZone(string $time, $from)
    {
        $carbon = Carbon::parse($time, $from);
        return $carbon->setTimezone(config('app.timezone'));
    }
}
