<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use App\Traits\FakeUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase, FakeUser;

    private string $endpoint = '/api/profile';

    public function testUnauthorizedUser(): void
    {
        $this->getJson($this->endpoint)->assertUnauthorized();
    }

    public function testItReturnsStatusOk(): void
    {
        $this->actingAsFakeUser();

        $this->getJson($this->endpoint)->assertOk();
    }
}
