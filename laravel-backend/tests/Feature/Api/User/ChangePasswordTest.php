<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use App\Traits\FakeUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase, FakeUser;

    private string $endpoint = '/api/change-password';

    public function testUnauthorizedUser(): void
    {
        $this->putJson($this->endpoint, [])->assertUnauthorized();
    }

    /**
     * @dataProvider provideInvalidJsonData
     */
    public function testItReturnsValidationErrors(array $invalidJsonData): void
    {
        $this->actingAsFakeUser();

        $this->putJson($this->endpoint, $invalidJsonData)->assertUnprocessable();
    }

    public function testChangePasswordIsSuccessful(): void
    {
        $this->actingAsFakeUser();

        $this->putJson($this->endpoint, [
            'current_password'      => $this->password,
            'password'              => $this->password,
            'password_confirmation' => $this->password,
        ])->assertOk();
    }

    public function provideInvalidJsonData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/change-password.json'), true);
    }
}
