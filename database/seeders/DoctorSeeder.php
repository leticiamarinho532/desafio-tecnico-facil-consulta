<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 6; $i++) {
            DB::table('medico')->insert([
                'nome' => Str::random(10),
                'especialidade' => Str::random(10),
                'cidade_id' => $i,
                'created_at' => DB::raw('CURRENT_TIMESTAMP')
            ]);
        }
    }
}
