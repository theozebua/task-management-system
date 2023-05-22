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
final class ProfileTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $seed = DatabaseSeeder::class;

    private string $endpoint = '/api/profile';
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
        $this->get($this->endpoint)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testItReturnsStatusOk(): void
    {
        $this
            ->withHeaders([
                'Authorization' => $this->token,
            ])
            ->get($this->endpoint)
            ->assertOK();
    }
}
