<?php

use Illuminate\Database\Seeder;

class SetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sets')->insert([
           'name'=>'Set 1'
        ]);

        DB::table('sets')->insert([
            'name'=>'Set 2'
        ]);

        DB::table('sets')->insert([
            'name'=>'Set 3'
        ]);
    }
}
