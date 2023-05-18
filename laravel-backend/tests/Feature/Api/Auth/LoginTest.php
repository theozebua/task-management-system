<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Traits\FakeUser;
use Database\Seeders\Testing\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, FakeUser;

    private string $endpoint = '/api/login';

    /**
     * @dataProvider provideInvalidJsonData
     */
    public function testItReturnsValidationErrors(array $invalidJsonData): void
    {
        $this->postJson($this->endpoint, $invalidJsonData)->assertUnprocessable();
    }

    public function testLoginIsFailed(): void
    {
        $this->postJson($this->endpoint, [
            'email'    => 'something@gmail.com',
            'password' => 'something',
        ])->assertUnauthorized();
    }

    public function testLoginIsSuccessful(): void
    {
        $this->seed(UserSeeder::class);

        $this->postJson($this->endpoint, [
            'email'    => $this->email,
            'password' => $this->password,
        ])->assertOk();
    }

    public function provideInvalidJsonData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/login.json'), true);
    }
}
