<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api_settings;
use Illuminate\Support\Facades\Hash;

class Api_settingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Api_settings::truncate();

        $api_token = Hash::make('token_prueba');
        $api_key = Hash::make('api_key');

        Api_settings::create([
            'api_name' => 'Prueba_Etraining',
            'api_key' => $api_key,
            'api_token' => $api_token,
            'activo' => true,
        ]);

    }
}
