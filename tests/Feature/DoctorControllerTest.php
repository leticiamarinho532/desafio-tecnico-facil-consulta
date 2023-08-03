<?php

namespace Tests\Feature;

use Database\Seeders\DoctorPatientSeeder;
use Database\Seeders\DoctorSeeder;
use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DoctorControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(
            [
                DoctorSeeder::class,
                DoctorPatientSeeder::class
            ]
        );
    }

    public function testShouldReturnAllDoctors(): void
    {
        // Act
        $response = $this->get('api/medicos');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([[
                    'id',
                    'nome',
                    'especialidade',
                    'cidade_id',
                    'created_at',
                    'updated_at',
                    'deleted_at',
            ]]);
    }

    public function testShouldReturnAllDoctorsByCity(): void
    {
        // Act
        $response = $this->get('api/cidades/' . rand(1, 5) . '/medicos');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([[
                    'id',
                    'nome',
                    'especialidade',
                    'cidade_id',
                    'created_at',
                    'updated_at',
                    'deleted_at',
            ]]);
    }

    public function testShouldReturnCreatedDoctor(): void
    {
        // Arrange
        $fakeDoctor = Doctor::factory()->make();
        $body = [
            $fakeDoctor
        ];

        // Act
        $response = $this->post('api/cidades', $body);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([[
                    'id',
                    'nome',
                    'especialidade',
                    'cidade_id',
                    'created_at',
                    'updated_at',
                    'deleted_at',
            ]]);
    }

    public function testShouldReturnLinkedDoctorPatient(): void
    {
        // Arrange
        $doctorId = rand(1, 5);
        $patientId = rand(1, 5);
        $body = [
            'medico_id' => $doctorId,
            'paciente_id' => $$patientId
        ];

        // Act
        $response = $this->post('api/medicos' . $doctorId . '/pacientes', $body);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'medico' => [
                    'id',
                    'nome',
                    'especialidade',
                    'cidade_id',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ],
                'paciente' => [
                    'id',
                    'nome',
                    'cpf',
                    'celular',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]
            ]);
    }
}
