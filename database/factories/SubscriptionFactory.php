<?php

namespace Database\Factories;


use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'expires_on'=>now()->endOfDay(),
            'expired'=>false,
            'payment_id'=>null,
            'device_id'=> null
        ];
    }
}
