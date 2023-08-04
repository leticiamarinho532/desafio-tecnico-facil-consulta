<?php

namespace Tests\Unit;

use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Services\PatientService;
use Illuminate\Support\Str;
use Tests\TestCase;

class PatientServiceTest extends TestCase
{
    private $patientRepositoryMock;
    private $fakeDoctors = [];
    private $fakePatients = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->patientRepositoryMock = $this->mock(PatientRepositoryInterface::class);
        ;

        for ($i = 1; $i < 6; $i++) {
            array_push($this->fakeDoctors, [
                'nome' => Str::random(10),
                'especialidade' => Str::random(10),
                'cidade_id' => $i,
                'created_at' => now()
            ]);
        }

        for ($i = 1; $i < 6; $i++) {
            array_push($this->fakePatients, [
                'nome' => Str::random(10),
                'cpf' => Str::random(10),
                'celular' => Str::random(10),
                'created_at' => now()
            ]);
        }
    }

    public function testShouldListAllDoctorsPatient(): void
    {
        // Arrange
        $fakePatients = $this->fakePatients;
        $this->patientRepositoryMock
            ->shouldReceive('getAllDoctorPatients')
            ->andReturn($fakePatients);
        $patientService = new PatientService($this->patientRepositoryMock);
        $doctorId = rand(1, 5);

        // Act
        $result = $patientService->getAllDoctorPatients($doctorId);

        // Assert
        $this->assertEquals($fakePatients, $result);
    }

    public function testShouldCreateAPatient(): void
    {
        // Arrange
        $fakePatient = end($this->fakePatients);
        $this->patientRepositoryMock
            ->shouldReceive('createPatient')
            ->andReturn($fakePatient);
        $patientService = new PatientService($this->patientRepositoryMock);
        $body = $fakePatient;

        // Act
        $result = $patientService->createPatient($body);

        // Assert
        $this->assertEquals($fakePatient, $result);
    }

    public function testShouldUpdateAPatient(): void
    {
        // Arrange
        $fakePatient = end($this->fakePatients);
        $this->patientRepositoryMock
            ->shouldReceive('updatePatient')
            ->andReturn($fakePatient);
        $patientService = new PatientService($this->patientRepositoryMock);
        $body = $fakePatient;
        $patientId = rand(1, 5);

        // Act
        $result = $patientService->updatePatient($patientId, $body);

        // Assert
        $this->assertEquals($fakePatient, $result);
    }
}
