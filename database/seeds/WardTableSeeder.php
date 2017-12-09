<?php

use Illuminate\Database\Seeder;

class WardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("wards")->delete();
        \App\Ward::insert([
            [
                'id' => 1,
                'slug' => bin2hex(random_bytes(64)),
                'state_id' => 'Administrator',
                'lga_id' => 'admin@codemansion.com',
                'name' => bcrypt('admin1234'),
                'code' => 1,
                'created_at' => '2017-03-09 09:19:28',
                'updated_at' => '2017-03-09 08:19:28',
            ],
        ]);
    }
}
