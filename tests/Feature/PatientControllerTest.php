<?php

namespace Tests\Feature;

use Database\Seeders\{
    PatientSeeder,
    DoctorPatientSeeder
};
use Tests\TestCase;
use Illuminate\Support\Str;

// use Illuminate\Foundation\Testing\DatabaseTruncation;

class PatientControllerTest extends TestCase
{
    // use DatabaseTruncation;

    private $fakePatients = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(
            [
                PatientSeeder::class,
                DoctorPatientSeeder::class
            ]
        );

        for ($i = 1; $i < 6; $i++) {
            array_push($this->fakePatients, [
                'nome' => Str::random(10),
                'cpf' => Str::random(10),
                'celular' => Str::random(10),
                'created_at' => now()
            ]);
        }
    }

    public function shouldShowPatientsFromOneDoctor(): void
    {
        // Act
        $response = $this->get('api/medicos/1/pacientes');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([[
                    'id',
                    'nome',
                    'cpf',
                    'celular',
                    'created_at',
                    'updated_at',
                    'deleted_at',
            ]]);
    }

    public function testShouldCreateAPatient(): void
    {
        // Arrange
        $fakePatient = end($this->fakePatients);
        $body = [
            $fakePatient
        ];

        // Act
        $response = $this->post('api/pacientes', $body);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'nome',
                'cpf',
                'celular',
                'created_at',
                'updated_at',
                'deleted_at',
        ]);
    }

    public function testShouldUpdateAPatient(): void
    {
        // Arrange
        $fakePatient = end($this->fakePatients);
        $body = [
            $fakePatient
        ];

        // Act
        $response = $this->post('api/pacientes/1', $body);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'nome',
                'cpf',
                'celular',
                'created_at',
                'updated_at',
                'deleted_at',
        ]);
    }
}
