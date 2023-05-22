<?php

declare(strict_types=1);

namespace App\Feature\Api\User;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Database\Seeds\DatabaseSeeder;

/**
 * @runTestsInSeparateProcesses
 */
final class ChangePasswordTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $seed = DatabaseSeeder::class;

    private string $endpoint = '/api/change-password';
    private string $token    = '';

    protected function setUp(): void
    {
        parent::setUp();

        $response = $this->withBodyFormat('json')->post('/api/login', [
            'email'    => 'johndoe@gmail.com',
            'password' => 'password',
        ])->response()->getJSON();

        $token       = json_decode($response, true)['token'];
        $this->token = sprintf('Bearer %s', $token);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testUnauthorizedUser(): void
    {
        $this->withBodyFormat('json')->put($this->endpoint)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @dataProvider provideInvalidJsonData
     */
    public function testItReturnsValidationErrors(array $invalidJsonData): void
    {
        $this
            ->withHeaders([
                'Authorization' => $this->token,
            ])
            ->withBodyFormat('json')
            ->put($this->endpoint, $invalidJsonData)
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testChangePasswordIsSuccessful(): void
    {
        $this
            ->withHeaders([
                'Authorization' => $this->token,
            ])
            ->withBodyFormat('json')
            ->put($this->endpoint, [
                'current_password'      => 'password',
                'password'              => 'password',
                'password_confirmation' => 'password',
            ])->assertOK();
    }

    public function provideInvalidJsonData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/change-password.json'), true);
    }
}
