<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([RoleSeeder::class]);
         User::create([
            'fname'=>"GAKIZA",
            'lname'=>"Abia",
            'email'=>"gakiza@gmail.com",
            'username'=>"gakiza",
            'telephone'=>"00257 62 241 262",
            'role_id'=>1,
            'password'=>Hash::make('1234')

         ]);
    }
}
