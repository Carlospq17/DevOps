<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //genera un usuario y se relaciona con el cliente inmediato
        \App\Models\User::factory(1)->create();
        \App\Models\Client::factory(1)->create();

        \App\Models\User::factory(1)->create();
        \App\Models\Client::factory(1)->create();

        \App\Models\Sale::factory(2)->create();

        \App\Models\Product::factory(2)->create();

        \App\Models\SalesProducts::factory(1)->create();

        \App\Models\Sale::factory(2)->create();

        \App\Models\Product::factory(2)->create();

        \App\Models\SalesProducts::factory(1)->create();
    }
}
