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
                'id'                        => 1,
                'host'                      => 'smtp.mailtrap.io',
                'username'                  => 'adffdsfasdadgd2334',
                'password'                  => 'adsfasdfadsf233',
                'port'                      => 456,
                'encryption'                => "tls",
                'enable_page_refresh'       => true,
                'enable_sound_notification' => true,
                'enable_integrity_check'    => false,
                'enable_report_image'       => false,
                'enable_ward_result'        => false,
                'enable_result_override'    => false
            ],
        ]);
    }
}
