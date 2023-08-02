<?php

namespace Tests\Feature;

use Database\Seeders\CitySeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class CityControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(
            [
                CitySeeder::class
            ]
        );
    }

    /**
     * A basic feature test example.
     */
    public function testShouldReturnAllCities(): void
    {
        // Act
        $response = $this->get('api/cidades');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([[
                    'id',
                    'nome',
                    'estado',
                    'created_at',
                    'updated_at',
                    'deleted_at',
            ]]);
    }
}
