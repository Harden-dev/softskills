<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class DevisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('devis')->insert([
            'id' => Str::random(6),
            'nature_client'=>'test',
            'type_service' => 'test',
            'budget'=>'500000',
            'nom_client'=>'test',
            'num_tel'=>'0102030405',
            'email'=>' test@mobile.com',
            'description'=>'cool',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
