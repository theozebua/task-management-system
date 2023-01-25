<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Traits\FakeUser;
use Database\Seeders\Testing\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function file_get_contents;

class RegisterTest extends TestCase
{
    use RefreshDatabase, FakeUser;

    private string $endpoint = '/api/register';

    /**
     * @dataProvider provideInvalidJsonData
     */
    public function testItReturnsValidationErrors(array $invalidJsonData): void
    {
        $this->seed(UserSeeder::class);

        $this->postJson($this->endpoint, $invalidJsonData)->assertUnprocessable();
    }

    public function testUserRegisteredSuccessfully(): void
    {
        $this->postJson($this->endpoint, [
            'name'                  => $this->name,
            'email'                 => $this->email,
            'password'              => $this->password,
            'password_confirmation' => $this->password,
        ])->assertCreated();
    }

    public function provideInvalidJsonData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/register.json'), true);
    }
}
