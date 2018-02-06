<?php

use Illuminate\Database\Seeder;

class PreferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table("preferences")->truncate();
        \App\Preference::insert([
            [
                'id' => 1,
                'page_refresh' => 1,
                'page_refresh_interval' => 30000,
                'sound_notification' => 1,
                'party_counter' => 1
            ],
        ]);
    }
}
