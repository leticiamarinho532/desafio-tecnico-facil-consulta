<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 6; $i++) {
            DB::table('cidades')->insert([
                'nome' => Str::random(10),
                'estado' => Str::random(10),
                'created_at' => DB::raw('CURRENT_TIMESTAMP')
            ]);
        }
    }
}
