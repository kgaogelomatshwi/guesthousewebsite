<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        $user = User::updateOrCreate([
            'email' => 'admin@riversideguesthouse.co.za',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password123'),
        ]);

        if ($adminRole) {
            $user->roles()->sync([$adminRole->id]);
        }
    }
}
