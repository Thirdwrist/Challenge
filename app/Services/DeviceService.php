<?php

namespace App\Services;

use App\Repositories\DeviceRepository;
use Illuminate\Http\Request;

class DeviceService
{
    protected $deviceRepository;
    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }
    public function createDevice(Request $request)
    {
        return $this->deviceRepository->create($request->all());
    }
}
