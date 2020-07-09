<?php

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
        \App\User::create([
            'code' => '3603111612960001',
            'email' => 'arieftb22@gmail.com',
            'name' => 'Arief Turbagus Nuril',
            'birthdate' => '1996-12-16 00:00:00',
            'phone' => '6281510837507',
            'password' => password_hash("@riefTB22", PASSWORD_DEFAULT)
        ]);
    }
}
