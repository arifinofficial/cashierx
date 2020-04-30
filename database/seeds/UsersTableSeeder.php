<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin'
        ]);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'hello@goudkoffie.co',
            'password' => Hash::make('adminGK'),
        ]);

        $user->assignRole('admin');
    }
}
