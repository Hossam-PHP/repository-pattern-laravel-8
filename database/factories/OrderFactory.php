<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;


class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'details'       => $this->faker->sentences(4, true),
            'client'         => $this->faker->name(),
            'is_fulfilled' => $this->faker->boolean(),
            'user_id' => 1,
        ];
    }
}
