<?php

namespace Tests\Feature;

use Database\Seeders\{
    PatientSeeder,
    DoctorPatientSeeder
};
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class PatientControllerTest extends TestCase
{
    private $fakePatients = [];
    private $user;
    private $userToken;

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

        $this->user = User::factory()->create();
        $this->userToken = JWTAuth::fromUser($this->user);
    }

    public function testShouldShowPatientsFromOneDoctor(): void
    {
        // Act
        $response = $this->withHeader('Authorization', 'Bearer' . $this->userToken)
            ->get('api/medicos/1/pacientes');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([[
                    'id',
                    'nome',
                    'cpf',
                    'celular',
                    'created_at',
                    'updated_at',
                    'deleted_at'
            ]]);
    }

    public function testShouldCreateAPatient(): void
    {
        // Arrange
        $fakePatient = end($this->fakePatients);
        $body = $fakePatient;

        // Act
        $response = $this->withHeader('Authorization', 'Bearer' . $this->userToken)
            ->post('api/pacientes', $body);

        // Assert
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'nome',
                'cpf',
                'celular',
                'created_at',
                'updated_at',
        ]);
    }

    public function testShouldUpdateAPatient(): void
    {
        // Arrange
        $fakePatient = end($this->fakePatients);
        $body = $fakePatient;

        // Act
        $response = $this->withHeader('Authorization', 'Bearer' . $this->userToken)
            ->put('api/pacientes/1', $body);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'nome',
                'cpf',
                'celular',
                'created_at',
                'updated_at',
                'deleted_at'
        ]);
    }
}
