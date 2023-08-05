<?php

namespace Tests\Feature;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    private $user;
    private $userToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->userToken = JWTAuth::fromUser($this->user);
    }
    public function testShouldLogin(): void
    {
        // Arrange
        $body = [
            'email' => $this->user->email,
            'password' => 'password'
        ];

        // Act
        $response = $this->post('/api/login', $body);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in'
            ]);
    }

    public function testShouldListLoggedInUserInfos(): void
    {
        // Act
        $response = $this->withHeader('Authorization', 'Bearer' . $this->userToken)
            ->get('api/user');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at'
            ]);
    }
}
