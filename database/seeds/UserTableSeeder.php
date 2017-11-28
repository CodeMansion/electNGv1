<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("users")->delete();
        \App\User::insert([
            [
                'id' => 1,
                'slug' => bin2hex(random_bytes(64)),
                'username' => 'Administrator',
                'email' => 'admin@codemansion.com',
                'password' => bcrypt('admin1234'),
                'user_type_id' => 1,
                'activated' => 1,
                'created_at' => '2017-03-09 09:19:28',
                'updated_at' => '2017-03-09 08:19:28',
            ],
        ]);
    }
}
