<?php

use Illuminate\Database\Seeder;

class UserCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('user_categories')->truncate();
        \App\UserCategory::insert(
            [
                'name'  => 'Administrator',
                'code' => 'ADMIN',
            ],
            [
                'name'  => 'Party Agent',
                'code' => 'PA',
            ],
            [
                'name'  => 'Candidate',
                'code' => 'CAND',
            ],
            [
                'name'  => 'Moderator',
                'code' => 'MOD',
            ]
        );
    }
}
