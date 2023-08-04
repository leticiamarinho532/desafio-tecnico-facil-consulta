<?php

namespace Tests\Unit;

use App\Services\DoctorService;
use App\Repositories\Interfaces\{
    DoctorPatientRepositoryInterface,
    DoctorRepositoryInterface
};
use Illuminate\Support\Str;
use Tests\TestCase;

class DoctorServiceTest extends TestCase
{
    private $doctorRepositoryMock;
    private $doctorPatientRepositoryMock;
    private $fakeDoctors = [];
    private $fakePatient = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->doctorRepositoryMock = $this->mock(DoctorRepositoryInterface::class);
        $this->doctorPatientRepositoryMock = $this->mock(DoctorPatientRepositoryInterface::class);

        for ($i = 1; $i < 6; $i++) {
            array_push($this->fakeDoctors, [
                'nome' => Str::random(10),
                'especialidade' => Str::random(10),
                'cidade_id' => $i,
                'created_at' => now()
            ]);
        }

        for ($i = 1; $i < 6; $i++) {
            array_push($this->fakePatient, [
                'nome' => Str::random(10),
                'cpf' => Str::random(10),
                'celular' => Str::random(10),
                'created_at' => now()
            ]);
        }
    }

    public function testShouldListAllDoctors()
    {
        // Arrange
        $fakeDoctors = $this->fakeDoctors;
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
        $fakeDoctors = $this->fakeDoctors;
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
        $fakeDoctor = end($this->fakeDoctors);
        $this->doctorRepositoryMock
            ->shouldReceive('createDoctor')
            ->andReturn($fakeDoctor);
        $doctorService = new DoctorService($this->doctorRepositoryMock, $this->doctorPatientRepositoryMock);
        $body = $fakeDoctor;

        // Act
        $result = $doctorService->storeDoctor($body);

        // Assert
        $this->assertEquals($fakeDoctor, $result);
    }

    public function testShouldLinkAnDoctorToAPatient()
    {
        // Arrange
        $fakeDoctor = end($this->fakeDoctors);
        $fakePatient = end($this->fakePatient);
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
        $result = $doctorService->createDoctorPatientLink($params);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
