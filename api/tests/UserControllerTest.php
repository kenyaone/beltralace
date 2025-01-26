<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use App\Controllers\UserController;
use App\Models\User;
use PDO;
use PDOStatement;

class UserControllerTest extends TestCase
{
    /** @var UserController */
    private $userController;

    /** @var PDO|MockObject */
    private $pdoMock;

    /** @var PDOStatement|MockObject */
    private $pdoStatementMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mock for PDO
        $this->pdoMock = $this->createMock(PDO::class);

        // Create mock for PDOStatement
        $this->pdoStatementMock = $this->createMock(PDOStatement::class);

        // Set up the UserController with the mocked PDO
        $this->userController = new UserController($this->pdoMock);
    }

    public function testCreateUserSuccess()
    {
        $user = new User('John', 'Doe', '1234567890', 'john@example.com', 'johnny', 'password', 'avatar.png');

        // Configure PDO mock to return the PDOStatement mock
        $this->pdoMock->method('prepare')->willReturn($this->pdoStatementMock);

        // Configure PDOStatement mock to simulate successful execution
        $this->pdoStatementMock->method('execute')->willReturn(true);
        $this->pdoMock->method('lastInsertId')->willReturn(1);

        $result = $this->userController->create($user);

        $this->assertEquals(1, $result['status']);
        $this->assertEquals('User created successfully', $result['message']);
        $this->assertEquals(1, $user->id);
    }

    public function testCreateUserFailure()
    {
        $user = new User('Jane', 'Doe', '0987654321', 'jane@example.com', 'janedoe', 'password', 'avatar2.png');

        // Configure PDO mock to return the PDOStatement mock
        $this->pdoMock->method('prepare')->willReturn($this->pdoStatementMock);

        // Configure PDOStatement mock to simulate a PDOException
        $this->pdoStatementMock->method('execute')->willThrowException(new \PDOException('Database error'));

        $result = $this->userController->create($user);

        $this->assertEquals(0, $result['status']);
        $this->assertEquals('Database error', $result['message']);
    }
}
