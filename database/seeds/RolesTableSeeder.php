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
        DB::table('roles')->insert([
            [
                'role_ar' => 'مستخدم',
                'role_en' => 'user',
                'plan' => '',
            ],
            [
                'role_ar' => 'مدير عام',
                'role_en' => 'Super Admin',
                'plan' => '*',
            ]
        ]);
    }
}
