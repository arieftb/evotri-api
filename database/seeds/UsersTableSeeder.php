<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'code' => '3603111612960001',
                'email' => 'arieftb22@gmail.com',
                'name' => 'Arief Turbagus Nuril',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837507',
                'password' => password_hash("@riefTB22", PASSWORD_DEFAULT),
            ],
            [
                'code' => '3603111612960011',
                'email' => 'user1@gmail.com',
                'name' => 'User Test 1',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837501',
                'password' => password_hash("11223344", PASSWORD_DEFAULT),
            ],
            [
                'code' => '3603111612960012',
                'email' => 'user2@gmail.com',
                'name' => 'User Test 2',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837502',
                'password' => password_hash("11223344", PASSWORD_DEFAULT),
            ],
            [
                'code' => '3603111612960013',
                'email' => 'user3@gmail.com',
                'name' => 'User Test 3',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837503',
                'password' => password_hash("11223344", PASSWORD_DEFAULT),
            ],
            [
                'code' => '3603111612960014',
                'email' => 'user4@gmail.com',
                'name' => 'User Test 4',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837504',
                'password' => password_hash("11223344", PASSWORD_DEFAULT),
            ],
            [
                'code' => '3603111612960015',
                'email' => 'user5@gmail.com',
                'name' => 'User Test 5',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837505',
                'password' => password_hash("11223344", PASSWORD_DEFAULT),
            ],
            [
                'code' => '3603111612960016',
                'email' => 'user6@gmail.com',
                'name' => 'User Test 6',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837506',
                'password' => password_hash("11223344", PASSWORD_DEFAULT),
            ],
            [
                'code' => '3603111612960017',
                'email' => 'user7@gmail.com',
                'name' => 'User Test 7',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837517',
                'password' => password_hash("11223344", PASSWORD_DEFAULT),
            ],
            [
                'code' => '3603111612960018',
                'email' => 'user8@gmail.com',
                'name' => 'User Test 8',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837508',
                'password' => password_hash("11223344", PASSWORD_DEFAULT),
            ],
            [
                'code' => '3603111612960019',
                'email' => 'user9@gmail.com',
                'name' => 'User Test 9',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837509',
                'password' => password_hash("11223344", PASSWORD_DEFAULT),
            ],
            [
                'code' => '3603111612960010',
                'email' => 'user10@gmail.com',
                'name' => 'User Test 10',
                'birthdate' => '1996-12-16 00:00:00',
                'phone' => '6281510837510',
                'password' => password_hash("11223344", PASSWORD_DEFAULT),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
