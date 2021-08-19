<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $faker = \Faker\Factory::create();

        $password = Hash::make('Colombia123');

        User::create([
            'name' => 'Admin',
            'identificacion' => '1234567',
            'email' => 'admin@test.com',
            'password' => $password,
        ]);

        for ($i = 0; $i < 11; $i++) {
            User::create([
                'name' => $faker->name,
                'identificacion' => rand(1234568,9999999),
                'email' => $faker->email,
                'password' => $password,
            ]);
        }
    }
}