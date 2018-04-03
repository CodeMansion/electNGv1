<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permissions')->truncate();
        \App\Permission::insert([
            'name'  => 'create-elections',
            'label' => 'Create Election',
        ]);
        \App\Permission::insert([
            'name'  => 'create-users',
            'label' => 'Create Users',
        ]);
        \App\Permission::insert([
            'name'  => 'create-parties',
            'label' => 'Create Political Parties',
        ]);
        \App\Permission::insert([
            'name'  => 'assign-party-to-election',
            'label' => 'Assign Party To Election',
        ]);
    }
}
