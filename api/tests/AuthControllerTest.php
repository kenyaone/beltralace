<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    private $authController;
    private $userControllerMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock UserController
        $this->userControllerMock = $this->createMock(UserController::class);

        // Inject the mock into AuthController
        $this->authController = new AuthController($this->userControllerMock);
    }

    public function testLoginWithEmptyFields()
    {
        $user = new User(null);

        $result = $this->authController->login($user);

        $this->assertEquals(0, $result['status']);
        $this->assertEquals('Empty email and/or password', $result['message']);
    }

    public function testLoginWithInactiveUser()
    {
        $user = new User(['email' =>'inactive@example.com', 'password' =>'password123']);

        // Set up the mock for getByEmail
        $this->userControllerMock->method('getByEmail')
            ->with($user->email)
            ->willReturn((object) ['active' => false]);

        $result = $this->authController->login($user);

        $this->assertEquals(0, $result['status']);
        $this->assertEquals('Inactive user account. Contact your administrator for assistance', $result['message']);
    }

    public function testLoginWithValidUser()
    {
        $user = new User(['email' =>'active@example.com', 'password' =>'password123']);

        // Set up the mock for getByEmail
        $this->userControllerMock->method('getByEmail')
            ->with($user->email)
            ->willReturn((object) ['active' => true]);

        $result = $this->authController->login($user);

        $this->assertEquals(1, $result['status']);
        $this->assertEquals('Login successful. Redirecting...', $result['message']);
    }
}
