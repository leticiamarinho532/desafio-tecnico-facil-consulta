<?php

namespace Tests\Unit;

use App\Models\City;
use App\Services\CityService;
use App\Repositories\Interfaces\CityRepositoryInterface;
use Tests\TestCase;
use Exception;
use Illuminate\Support\Str;

class CityServiceTest extends TestCase
{
    private $cityRepositoryMock;
    private $fakeCities = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->cityRepositoryMock = $this->mock(CityRepositoryInterface::class);

        for ($i = 1; $i < 6; $i++) {
            array_push($this->fakeCities, [
                'nome' => Str::random(10),
                'estado' => Str::random(10),
                'created_at' => now()
            ]);
        }
    }

    public function testShouldListAllCities(): void
    {
        // Arrange
        $fakeCities = $this->fakeCities;
        $this->cityRepositoryMock
            ->shouldReceive('getAll')
            ->andReturn($fakeCities);
        $cityService = new CityService($this->cityRepositoryMock);

        // Act
        $result = $cityService->getAll();

        // Assert
        $this->assertEquals($fakeCities, $result);
    }

    public function testShouldReturnEmptyWhenNoCitiesStored(): void
    {
        // Arrange
        $fakeCities = [];
        $this->cityRepositoryMock
            ->shouldReceive('getAll')
            ->andReturn($fakeCities);
        $cityService = new CityService($this->cityRepositoryMock);

        // Act
        $result = $cityService->getAll();

        // Assert
        $this->assertEquals($fakeCities, $result);
    }

    public function testShouldThrowErrorMessageWhenErrorOccurs(): void
    {
        // Arrange
        $this->cityRepositoryMock
            ->shouldReceive('getAll')
            ->andThrow(new Exception('Expected Exception was thrown'));

        $cityService = new CityService($this->cityRepositoryMock);

        // Act
        $result = $cityService->getAll();

        // Assert
        $this->assertArrayHasKey('error', $result);
    }
}
