<?php

use Illuminate\Database\Seeder;
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
        $user_input = [
            'name'               => 'Admin',
            'email'              => 'patricio.quezada05@gmail.com',
            'username'           => 'admin',
            'password'           => bcrypt('8dB8ZFfWcmB3ZkqL'),
            'verified'           => User::VERIFIED_USER,
            'verification_token' => User::generateVerificationCode(),
            'admin'              => User::ADMIN_USER
        ];
        User::create($user_input);
        
    }
}
