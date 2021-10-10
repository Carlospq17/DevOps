<?php

namespace Database\Factories;

use App\Models\SalesProducts;
use App\Models\{Sale, Product};
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesProducts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sales_id' => Sale::all()->last(),
            'products_id' => Product::all()->last(),
            'amount' => $this->faker->randomFloat(2, 0, 8),
        ];
    }
}
