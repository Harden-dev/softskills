<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('contacts')->insert([
            'id' => Str::random(6),
            'nom_prenom'=>'test',
            'email' => 'test@gmail.com',
            'telephone'=>'0102030405',
            'message'=>'bon service',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
