<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'regular'
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role]);
        }


        $admin = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123123'),
            'role_id' => Role::where('name', 'admin')->first()->id
        ];

        User::updateOrCreate(['email' => $admin['email']], $admin);
    }
}
