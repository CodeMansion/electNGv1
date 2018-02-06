<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Category default data
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('roles')->truncate();
        
        $id = \App\Role::insertGetId([
            [
		        'name' => 'Administrator',
		        'label' => 'Administrator Access',
            ],
            [
		        'name' => 'Candidate',
		        'label' => 'Candidate Access',
            ]
        ]);
    }
}
