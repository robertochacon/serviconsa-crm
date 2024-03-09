<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Start extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([[
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt("admin"),
            'role' => "admin",
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ],[
            'name' => 'Carla',
            'email' => 'carla@gmail.com',
            'password' => bcrypt("carla"),
            'role' => "user",
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ]]);

        DB::table('providers')->insert([[
            'name' => 'Hormigones Bonao',
            'phone' => null,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ]]);
    }
}
