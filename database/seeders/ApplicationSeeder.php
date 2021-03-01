<?php

namespace Database\Seeders;

use App\Enums\DeviceEnum;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use App\Models\Device;
use App\Models\App;
use App\Models\Payment;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App::factory()->count(1)->create()->each(function(App $app){

            Device::factory()->google()->count(100000)->state(['app_id'=> $app])->create()->each(function(Device $device){
                    Payment::factory()->count(1)->state(['device_id'=>$device->id])->create()->each(function(Payment $payment){
                        Subscription::factory()->count(1)->state(['device_id'=>$payment->device->id, 'payment_id'=>$payment->id ])->create();
                    });
            });
        });
    }
}
