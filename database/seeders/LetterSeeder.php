<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('letters')->insert([
            'id' => Str::random(6),
            'email' => 'test@gmail.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
