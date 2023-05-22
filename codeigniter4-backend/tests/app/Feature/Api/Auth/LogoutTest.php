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
final class LogoutTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $seed = DatabaseSeeder::class;

    private string $endpoint = '/api/logout';

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testLogoutIsFailed(): void
    {
        $this->post($this->endpoint)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testLogoutIsSuccessful(): void
    {
        $response = $this->withBodyFormat('json')->post('/api/login', [
            'email'    => 'johndoe@gmail.com',
            'password' => 'password',
        ])->response()->getJSON();

        $response = json_decode($response, true);

        $this->withHeaders([
            'Authorization' => sprintf('Bearer %s', $response['token'])
        ])->post($this->endpoint)->assertOK();
    }
}
