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
        App\User::create(
        [
            'id_store' => '0',
            'username' => 'admin',
            'name' => "admin",
            'email' => "admin@gmail.com",
            'password' => bcrypt("admin"),
            'role' => '0'
        ],
        // [
        //     'username' => 'owner',
        //     'name' => "owner",
        //     'email' => "owner@gmail.com",
        //     'password' => bcrypt("owner"),
        // ]

        );
    }
}
