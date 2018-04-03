<?php

use Illuminate\Database\Seeder;

class ElectionStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('election_statuses')->truncate();

        DB::table('election_statuses')->insert([
            'name' => 'Processing',
            'slug' => 'unprocessed',
            'class' => 'warning'
        ]);

        DB::table('election_statuses')->insert([
            'name' => 'On-going',
            'slug' => 'active',
            'class' => 'success'
        ]);

        DB::table('election_statuses')->insert([
            'name' => 'Ended',
            'slug' => 'ended',
            'class' => 'primary'
        ]);

        DB::table('election_statuses')->insert([
            'name' => 'Canceled',
            'slug' => 'cancaled',
            'class' => 'danger'
        ]);
    }
}
