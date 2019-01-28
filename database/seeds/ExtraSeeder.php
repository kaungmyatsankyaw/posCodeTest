<?php

use Illuminate\Database\Seeder;

class ExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('extras')->insert([
            'item_id' => 1,
            'name'=>'Upsize',
            'price' => 0.00
        ]);

        DB::table('extras')->insert([
            'item_id' => 1,
            'name'=>'1 Extra Hot ',
            'price' => 4.00
        ]);
    }
}
