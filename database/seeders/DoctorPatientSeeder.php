<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DoctorPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 6; $i++) {
            DB::table('medico_paciente')->insert([
                'medico_id' => $i,
                'paciente_id' => $i,
                'created_at' => DB::raw('CURRENT_TIMESTAMP')
            ]);
        }
    }
}
