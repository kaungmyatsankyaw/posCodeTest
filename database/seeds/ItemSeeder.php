<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'name' => 'Espresso',
            'price' => '2.50'
        ]);

        DB::table('items')->insert([
            'name' => 'Blueberry Muffin',
            'price' => '2.50'
        ]);

        DB::table('items')->insert([
            'name' => 'Cafe Latte',
            'price' => 4.00
        ]);

        DB::table('items')->insert([
            'name' => 'Hazelnut Latte',
            'price' => 4.00
        ]);

        DB::table('items')->insert([
            'name' => 'Cappuccino',
            'price' => 4.00
        ]);



    }
}
