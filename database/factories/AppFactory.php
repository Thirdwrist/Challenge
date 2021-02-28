<?php

namespace Database\Factories;

use App\Models\App;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = App::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pass = bcrypt('password');
        return [
            'name'=> $this->faker->company,
            'google_username'=>$this->faker->userName,
            'ios_username'=>$this->faker->userName,
            'google_password'=>$pass,
            'ios_password'=>$pass,
            'description'=>$this->faker->text(100)
        ];
    }
}
