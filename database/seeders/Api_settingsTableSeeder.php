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

        $api_token = "$2y$10$U54AVkcMA5HrkVf2WUZrhuMnwaFoOA1FV8zAEeL956pHTxiLWAuIm";
        $api_key = "$2y$10$LRyUsiLNnQQzuo8t9lkJlukE5SXisBS7wW5v7.8s4HJlqAaT3aWMO";

        Api_settings::create([
            'api_name' => 'Prueba_Etraining',
            'api_key' => $api_key,
            'api_token' => $api_token,
            'activo' => true,
        ]);

    }
}
