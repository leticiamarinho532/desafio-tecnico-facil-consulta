<?php

namespace Tests\Feature;

use Database\Seeders\{
    CitySeeder,
    DoctorPatientSeeder,
    DoctorSeeder
};
use App\Models\User;
// use Illuminate\Foundation\Testing\DatabaseTruncation;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class DoctorControllerTest extends TestCase
{
    // use DatabaseTruncation;

    private $fakeDoctors = [];
    private $user;
    private $userToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(
            [
                CitySeeder::class,
                DoctorSeeder::class,
                DoctorPatientSeeder::class
            ]
        );

        for ($i = 1; $i < 6; $i++) {
            array_push($this->fakeDoctors, [
                'nome' => Str::random(10),
                'especialidade' => Str::random(10),
                'cidade_id' => $i,
                'created_at' => now()
            ]);
        }

        $this->user = User::factory()->create();
        $this->userToken = JWTAuth::fromUser($this->user);
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
                    'deleted_at'
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
                    'deleted_at'
            ]]);
    }

    public function testShouldReturnCreatedDoctor(): void
    {
        // Arrange
        $fakeDoctor = end($this->fakeDoctors);
        $body = $fakeDoctor;

        // Act
        $response = $this->withHeader('Authorization', 'Bearer' . $this->userToken)
            ->post('api/medicos', $body);

        // Assert
        $response->assertStatus(201)
            ->assertJsonStructure([
                    'id',
                    'nome',
                    'especialidade',
                    'cidade_id',
                    'created_at',
                    'updated_at',
            ]);
    }

    public function testShouldReturnLinkedDoctorPatient(): void
    {
        // Arrange
        $doctorId = rand(1, 5);
        $patientId = rand(1, 5);
        $body = [
            'medico_id' => $doctorId,
            'paciente_id' => $patientId
        ];

        // Act
        $response = $this->withHeader('Authorization', 'Bearer' . $this->userToken)
            ->post('api/medicos/' . $doctorId . '/pacientes', $body);

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
                    'deleted_at'
                ],
                'paciente' => [
                    'id',
                    'nome',
                    'cpf',
                    'celular',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ]
            ]);
    }
}
