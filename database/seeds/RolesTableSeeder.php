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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('roles')->truncate();
        \App\Role::insert([
            'name'  => 'admin',
            'label' => 'Administrator Access',
        ]);
        \App\Role::insert([
            'name'  => 'moderator',
            'label' => 'Modrator Access',
        ]);
        \App\Role::insert([
            'name'  => 'agent',
            'label' => 'Party Agent Access',
        ]);
        \App\Role::insert([
            'name'  => 'contestant',
            'label' => 'Eleaction Candidate Access',
        ]);
    }
}
