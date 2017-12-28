<?php

use Illuminate\Database\Seeder;

class ElectionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('election_types')->truncate();

        DB::table('election_types')->insert([
            'slug' => bin2hex(random_bytes(64)),
            'name' => 'Presidency',
            'code' => 'success',
            'description' => 'Presidential election which covers the whole states.'
        ]);

        DB::table('election_types')->insert([
            'slug' => bin2hex(random_bytes(64)),
            'name' => 'Governorship',
            'code' => 'success',
            'description' => 'Governorship election which happens within a state.'
        ]);

        DB::table('election_types')->insert([
            'slug' => bin2hex(random_bytes(64)),
            'name' => 'Senatorial',
            'code' => 'secondary',
            'description' => 'Senatorial election for state constituencies.'
        ]);

        DB::table('election_types')->insert([
            'slug' => bin2hex(random_bytes(64)),
            'name' => 'Local Government',
            'code' => 'secondary',
            'description' => 'Local government election in a state or constituency.'
        ]);
    }
}
