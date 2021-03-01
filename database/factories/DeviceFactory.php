<?php

namespace Database\Factories;

use App\Enums\DeviceEnum;
use App\Models\App;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name(),
            'lang'=>'en',
            'app_id'=> App::factory(),
        ];
    }

    public function ios()
    {
        return $this->state(function (array $attributes) {
            return [
                'os' => DeviceEnum::IOS,
                'appid'=> $this->faker->numberBetween(111111)
            ];
        });
    }

    public function google()
    {
        return $this->state(function (array $attributes) {
            return [
                'os' => DeviceEnum::GOOGLE,
                'uid'=> $this->faker->numberBetween(11,1111)
            ];
        });
    }
}
