<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'mobile' => 9999292924,
            'password' => bcrypt('secret'),
            'role_id' => '1'
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'mobile' => 9999292926,
            'password' => bcrypt('secret'),
            'role_id' => '2'
        ]);

        User::create([
            'name' => 'Technician',
            'email' => 'technician@technician.com',
            'mobile' => 9999292923,
            'password' => bcrypt('secret'),
            'role_id' => '3'
        ]);
    }
}
