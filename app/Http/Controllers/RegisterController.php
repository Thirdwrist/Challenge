<?php

namespace App\Http\Controllers;

use App\Enums\DeviceEnum;
use App\Models\Device;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Traits\RequestTrait;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;


class RegisterController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, RequestTrait;

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'=>['sometimes', 'string'],
            'app_id'=> ['required', 'exists:apps,id'],
            'appid'=>[Rule::requiredIf(($os = strtoupper($request->os)) === DeviceEnum::IOS)],
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

        $device = Device::create([
               'name'=> $request->name ?? null,
               'app_id'=> $request->app_id,
               'os'=> $os,
               'lang'=> $request->lang,
               'appid'=> ($os === DeviceEnum::IOS) ? $request->appid: null,
               'uid'=> ($os === DeviceEnum::GOOGLE) ? $request->uid: null
        ]);
        $data = [
            'access_token'=> $device->createToken($request->uid ?? $request->appid)->plainTextToken
        ];
         return $this->response(Response::HTTP_CREATED, $data);
    }

    public function fake()
    {

        $res = Http::post('store.apple.com/api/verify', [
            'receipt'=>111111,
        ])->json();

        $resGoogle = Http::post('play.google.com/api/verify', [
            'receipt'=>01234566
        ])->json();

        // $subGoogle = 

        return response($resGoogle);

    }
}
