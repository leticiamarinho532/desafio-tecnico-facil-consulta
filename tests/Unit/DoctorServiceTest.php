<?php

namespace Tests\Unit;

use App\Models\Doctor;
use App\Services\DoctorService;
use App\Repositories\Interfaces\{
    DoctorPatientRepositoryInterface, DoctorRepositoryInterface
};
use Illuminate\Support\Str;
use Tests\TestCase;

class DoctorServiceTest extends TestCase
{
    private $doctorRepositoryMock;
    private $doctorPatientRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->doctorRepositoryMock = $this->mock(DoctorRepositoryInterface::class);
        $this->doctorPatientRepositoryMock = $this->mock(DoctorPatientRepositoryInterface::class);
    }

    public function testShouldListAllDoctors()
    {
        // Arrange
        $fakeDoctors = Doctor::factory()->times(10)->make();
        $this->doctorRepositoryMock
            ->shouldReceive('getAll')
            ->andReturn($fakeDoctors);
        $doctorService = new DoctorService($this->doctorRepositoryMock, $this->doctorPatientRepositoryMock);

        // Act
        $result = $doctorService->getAll();

        // Assert
        $this->assertEquals($fakeDoctors, $result);
    }

    public function testShouldListAllDoctorsFromOneCity()
    {
        // Arrange
        $fakeDoctors = Doctor::factory()->times(10)->make();
        $this->doctorRepositoryMock
            ->shouldReceive('getAllByCity')
            ->andReturn($fakeDoctors);
        $doctorService = new DoctorService($this->doctorRepositoryMock, $this->doctorPatientRepositoryMock);
        $cityId = 1;

        // Act
        $result = $doctorService->getAllByCity($cityId);

        // Assert
        $this->assertEquals($fakeDoctors, $result);
    }

    public function testShouldStoreADoctor()
    {
        // Arrange
        $fakeDoctor = Doctor::factory()->make();
        $this->doctorRepositoryMock
            ->shouldReceive('createDoctor')
            ->andReturn($fakeDoctor);
        $doctorService = new DoctorService($this->doctorRepositoryMock, $this->doctorPatientRepositoryMock);
        $body = [
            'nome' => Str::random(15),
            'especialidade' => Str::random(10),
            'cidade' => Str::random(5)
        ];

        // Act
        $result = $doctorService->storeDoctor($body);

        // Assert
        $this->assertEquals($fakeDoctor, $result);
    }

    public function testShouldLinkAnDoctorToAPatient()
    {
        // Arrange
        $fakeDoctor = Doctor::factory()->make();
        $fakePatient = [
            'nome' => Str::random(10),
            'cpf' => Str::random(10),
            'celular' => Str::random(10)
        ];
        $expectedResult = [
            $fakeDoctor,
            $fakePatient
        ];
        $this->doctorPatientRepositoryMock
            ->shouldReceive('createDoctorPatientLink')
            ->andReturn($expectedResult);
        $doctorService = new DoctorService($this->doctorRepositoryMock, $this->doctorPatientRepositoryMock);
        $params = [
            'medico_id' => rand(1, 5),
            'paciente_id' => rand(1, 5)
        ];

        // Act
        $result = $doctorService->createDoctorPatientLink($params['medico_id'], $params['paciente_id']);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
