<?php

namespace App\Http\Controllers;

use App\Enums\DeviceEnum;
use App\Models\Device;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Traits\RequestTrait;
use App\Models\Subscription;
use App\Services\DeviceService;
use App\Services\SubscriptionService;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;


class RegisterController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, RequestTrait;

    private $deviceService;
    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'=>['sometimes', 'string'],
            'app_id'=> ['required', 'exists:apps,id'],
            'appid'=>[Rule::requiredIf(strtoupper($request->os) === DeviceEnum::IOS)],
            'uid'=>[Rule::requiredIf(strtoupper($request->os) === DeviceEnum::GOOGLE)],
            'lang'=>['string', 'required'],
            'os' => ['string', 'required', static function($attribute, $value, $fail){
                $os = strtoupper($value);
                if($os !== DeviceEnum::GOOGLE && $os !== DeviceEnum::IOS){
                    $fail("invalid $attribute");
                }
            }],

        ]);


        if(strtoupper($request->os) === DeviceEnum::IOS)
            $IOSDevice =  Device::where('appid', $request->appid)->exists();
        if(strtoupper($request->os) === DeviceEnum::GOOGLE)
            $googleDevice = Device::where('uid', $request->uid)->exists();
        if((isset($googleDevice) && $googleDevice) || (isset($IOSDevice) && $IOSDevice) )
            return $this->response(Response::HTTP_OK);

        $device = $this->deviceService->createDevice($request);
        $data = [
            'access_token'=> $device->createToken($request->uid ?? $request->appid)->plainTextToken
        ];
         return $this->response(Response::HTTP_CREATED, $data);
    }

}
