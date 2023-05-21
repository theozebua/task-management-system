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
final class RegisterTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $seed = DatabaseSeeder::class;

    private string $endpoint = '/api/register';

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
        $this->withBodyFormat('json')->post($this->endpoint, $invalidJsonData)
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testUserRegisteredSuccessfully(): void
    {
        $this->withBodyFormat('json')->post($this->endpoint, [
            'name'                  => 'Jane Doe',
            'email'                 => 'janedoe@gmail.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])->assertStatus(Response::HTTP_CREATED);
    }

    public function provideInvalidJsonData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/register.json'), true);
    }
}
