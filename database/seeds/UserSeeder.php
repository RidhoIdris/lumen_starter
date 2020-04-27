<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        $user = \App\User::create(
            [
            'name'  => 'admin',
            'email' => 'admin@gmail.com',
            'password'  => Hash::make('secret')
            ]);
        $user->syncRoles(['admin']);
        $user = \App\User::create(
            [
            'name'  => 'user',
            'email' => 'user@gmail.com',
            'password'  => Hash::make('secret')
            ]);
        $user->syncRoles(['user']);
            
    }
}
