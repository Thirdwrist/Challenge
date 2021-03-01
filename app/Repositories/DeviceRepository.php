<?php

namespace  App\Repositories;

use App\Enums\DeviceEnum;
use App\Models\Device;
use Illuminate\Support\Facades\DB;

class DeviceRepository {

    public function create(array $data)
    {

        DB::transaction(function () use ($data, &$device){
            $device = Device::create([
               'name'=> array_key_exists('name', $data) ? $data['name']: null,
               'app_id'=> $data['app_id'],
               'os'=> $os = strtoupper($data['os']),
               'lang'=> $data['lang'],
               'appid'=> ($os === DeviceEnum::IOS) ? $data['appid']: null,
               'uid'=> ($os === DeviceEnum::GOOGLE) ? $data['uid']: null
            ]);
        });

        return $device;
    }
}
