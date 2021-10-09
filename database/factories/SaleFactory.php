<?php

namespace Database\Factories;

use App\Models\{Sale, Client};
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'total_amount' => $this->faker->randomFloat(2, 0, 100),
            'date' => $this->faker->date(),
            'client_id' => Client::all()->last()
        ];
    }
}
