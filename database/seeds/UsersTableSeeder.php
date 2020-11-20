<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'abd.orabi94',
            'mobile' => '9961023624205',
            'email' => 'abd.asaad1994@gmail.com',
            'password' => bcrypt('123456789'),
            'type' => 'admin',
            'active' => 'active',
            'role_id' => 2,
        ]);
    }
}
