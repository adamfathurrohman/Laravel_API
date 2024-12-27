<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $roleCustomer = \Spatie\Permission\Models\Role::create(['name' => 'customer']);

        $userAdmin = \App\Models\User::create([
            "name"=> "Admin",
            "email"=> "admin@music.com",
            "password"=> bcrypt("admin123"),
        ]);

        $userAdmin->assignRole($roleAdmin);
        
    }
}
