<?php

namespace Tests\Unit;

use App\Models\City;
use App\Services\CityService;
use App\Repositories\Interfaces\CityRepositoryInterface;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class CityServiceTest extends TestCase
{
    private $cityRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cityRepositoryMock = $this->mock(CityRepositoryInterface::class);
    }

    // public function testShouldListAllCities(): void
    // {
    //     // Arrange
    //     $fakeCities = City::factory()->times(10)->make();
    //     $this->cityRepositoryMock
    //         ->shouldReceive('getAll')
    //         ->andReturn($fakeCities);
    //     $cityService = new CityService($this->cityRepositoryMock);

    //     // Act
    //     $result = $cityService->getAll();

    //     // Assert
    //     $this->assertEquals($fakeCities, $result);
    // }

    // public function testShouldReturnEmptyWhenNoCitiesStored(): void
    // {
    //     // Arrange
    //     $fakeCities = [];
    //     $this->cityRepositoryMock
    //         ->shouldReceive('getAll')
    //         ->andReturn($fakeCities);
    //     $cityService = new CityService($this->cityRepositoryMock);

    //     // Act
    //     $result = $cityService->getAll();

    //     // Assert
    //     $this->assertEquals($fakeCities, $result);
    // }

    // public function testShouldThrowErrorMessageWhenErrorOccurs(): void
    // {
    //     // Assert
    //     $this->expectException(InvalidArgumentException::class);

    //     // Arrange
    //     $fakeCities = City::factory()->times(10)->make();
    //     $this->cityRepositoryMock
    //         ->shouldReceive('getAll')
    //         ->throw
    //     $cityService = new CityService($this->cityRepositoryMock);

    //     // Act
    //     $result = $cityService->getAll();
    // }
}
