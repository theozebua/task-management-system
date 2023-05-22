<?php

declare(strict_types=1);

namespace App\Feature\Api\Auth;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Database\Seeds\DatabaseSeeder;

/**
 * @runTestsInSeparateProcesses
 */
final class LoginTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $seed = DatabaseSeeder::class;

    private string $endpoint = '/api/login';

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @dataProvider provideInvalidJsonData
     */
    public function testItReturnsValidationErrors(array $invalidJsonData): void
    {
        $this->withBodyFormat('json')
            ->post($this->endpoint, $invalidJsonData)
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testLoginIsFailed(): void
    {
        $this->withBodyFormat('json')->post($this->endpoint, [
            'email'    => 'something@gmail.com',
            'password' => 'something',
        ])->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testLoginIsSuccessful(): void
    {
        $this->withBodyFormat('json')->post($this->endpoint, [
            'email'    => 'johndoe@gmail.com',
            'password' => 'password',
        ])->assertOK();
    }

    public function provideInvalidJsonData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/login.json'), true);
    }
}
