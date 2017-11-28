<?php

use Illuminate\Database\Seeder;

class UserProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("user_profiles")->delete();
        \App\UserProfile::insert([
            [
                'id' => 1,
                'slug' => bin2hex(random_bytes(64)),
                'user_id' => 1,
                'first_name' => 'System',
                'last_name' => 'Admin',
                'phone' => '09011100022',
                'res_address' => 'FCT - Abuja',
                'created_at' => '2017-03-09 09:19:28',
                'updated_at' => '2017-03-09 08:19:28',
            ],
        ]);
    }
}
