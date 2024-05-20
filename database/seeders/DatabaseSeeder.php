<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call([
            RoleSeeder::class
        ]); 

        $this->call([
            UserSeeder::class
        ]); 

        // User::factory(100)->create();

        $this->call([
            AnnouncementSeeder::class
        ]); 

        $this->call([
            PostSeeder::class
        ]); 

        $this->call([
            StudentsSeeder::class
        ]); 
    }
}
