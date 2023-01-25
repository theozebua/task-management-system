<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Traits\FakeUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase, FakeUser;

    private string $endpoint = '/api/logout';

    public function testLogoutIsFailed(): void
    {
        $this->postJson($this->endpoint)->assertUnauthorized();
    }

    public function testLogoutIsSuccessful(): void
    {
        $this->actingAsFakeUser();

        $this->postJson($this->endpoint)->assertOk();
    }
}
