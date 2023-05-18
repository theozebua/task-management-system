<?php

declare(strict_types=1);

namespace App\Feature\Api\Auth\LoginTest;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

final class LoginTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = 'App';
    protected $seed      = 'DatabaseSeeder';
    protected $basePath  = APPPATH . 'Database';

    private string $endpoint = '/api/login';

    final protected function setUp(): void
    {
        parent::setUp();
    }

    final protected function tearDown(): void
    {
        parent::tearDown();
    }

    final public function testLoginIsFailed(): void
    {
        $this->post($this->endpoint, [
            'email'    => 'something@gmail.com',
            'password' => 'something',
        ])->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    final public function testLoginIsSuccessful(): void
    {
        $this->post($this->endpoint, [
            'email'    => 'johndoe@gmail.com',
            'password' => 'password',
        ])->assertOK();
    }

    /**
     * @dataProvider provideInvalidJsonData
     */
    final public function testItReturnsValidationErrors(array $invalidJsonData): void
    {
        $this->post($this->endpoint, $invalidJsonData)
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    final public function provideInvalidJsonData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/login.json'), true);
    }
}
