<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('login')->insert([
            'user' => 'Novesosiaplaze_official',
            'nomor_handphone' => '0721386172',
            'password' => Hash::make('jinan0803'),
            'namadepan' => 'Novesosiaplaze',
            'namabelakang' => 'official',
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => Str::random(30),
            'role' => 'admin',
        ]);
    }
}
