<?php

use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('genders')->truncate();
        \App\Gender::insert(
            ['name' => 'Male'],
            ['name' => 'Female']
        );
    }
}
