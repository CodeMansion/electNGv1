<?php

use Illuminate\Database\Seeder;

class UserTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('user_types')->truncate();

        \App\UserType::insert([
            [
                'slug' => bin2hex(random_bytes(64)),
                'code' => 'ADMIN',
                'name' => 'Administrator',
                'description' => 'System Administrator',
            ],[
                'slug' => bin2hex(random_bytes(64)),
                'code' => 'FIELD AGENT',
                'name' => 'Field Agent',
                'description' => 'Electorates',
            ],[
                'slug' => bin2hex(random_bytes(64)),
                'code' => 'CANDIDATE',
                'name' => 'Candidate',
                'description' => 'Candidate',
            ],
        ]);
    }
}
