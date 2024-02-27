<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('services')->insert([
            'id' => Str::random(6),
            'nom_prenom'=>'test',
            'email' => 'test@gmail.com',
            'contact'=>'0102030405',
            'type_services'=>'application mobile',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
