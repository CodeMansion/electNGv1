<?php

use Illuminate\Database\Seeder;

class PoliticalPartyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("political_parties")->delete();
        \App\PoliticalParty::insert([
            [
                'id' => 1,
                'slug' => bin2hex(random_bytes(64)),
                'name' => 'People Democratic Party',
                'code' => 'PDP',
                'description' => 'The people democratic party',
                'created_at' => '2017-03-09 09:19:28',
                'updated_at' => '2017-03-09 08:19:28',
            ],
            [
                'id' => 2,
                'slug' => bin2hex(random_bytes(64)),
                'name' => 'All Progressive Congress',
                'code' => 'APC',
                'description' => 'All Progressive Congress',
                'created_at' => '2017-03-09 09:19:28',
                'updated_at' => '2017-03-09 08:19:28',
            ],
            [
                'id' => 3,
                'slug' => bin2hex(random_bytes(64)),
                'name' => 'All Progressives Grand Alliance',
                'code' => 'APGA',
                'description' => 'All Progressives Grand Alliance',
                'created_at' => '2017-03-09 09:19:28',
                'updated_at' => '2017-03-09 08:19:28',
            ],
            [
                'id' => 4,
                'slug' => bin2hex(random_bytes(64)),
                'name' => 'Labour Party',
                'code' => 'LP',
                'description' => 'Labour party',
                'created_at' => '2017-03-09 09:19:28',
                'updated_at' => '2017-03-09 08:19:28',
            ],
            [
                'id' => 5,
                'slug' => bin2hex(random_bytes(64)),
                'name' => 'New Nigeria People Party',
                'code' => 'NNPP',
                'description' => 'New Nigeria people party',
                'created_at' => '2017-03-09 09:19:28',
                'updated_at' => '2017-03-09 08:19:28',
            ],
        ]);
    }
}
