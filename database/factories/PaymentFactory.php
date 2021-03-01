<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'receipt'=>$this->faker->numberBetween(111111),
            'status'=> 'success',
            'device_id'=> Device::factory()
        ];
    }
}
