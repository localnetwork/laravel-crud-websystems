<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersData = [
            [
                'name' => 'Diome',
                'avatar' => 'cow',
                'avatar_color' => 'blue', 
                'email' => 'admin@gmail.com',
                'role_id' => 1,
                'password' => Hash::make('1'),
            ],
            [
                'name' => 'Member',
                'avatar' => 'cow',
                'avatar_color' => 'blue',
                'email' => 'member@member.com',
                'role_id' => 2,
                'password' => Hash::make('1'),
            ],
        ];

        DB::table('users')->insert($usersData);
        User::factory(100)->create();
    }
}