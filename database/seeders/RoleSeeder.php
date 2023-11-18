<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Role::insert(["name" =>"Manager"]);
            Role::insert(["name" =>"Manager2"]);
            Role::insert(["name" =>"Seller"]);
            Role::insert(["name" =>"Inactif"]);

    }
}
