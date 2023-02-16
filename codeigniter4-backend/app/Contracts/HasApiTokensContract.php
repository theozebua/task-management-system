<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\PersonalAccessToken;
use App\DTOs\NewAccessToken;
use DateTimeInterface;

interface HasApiTokensContract
{
    /**
     * Return the instance of `\App\Models\PersonalAccessToken`.
     * 
     * @return PersonalAccessToken
     */
    public function tokens(): PersonalAccessToken;

    /**
     * Create a token for the specific model
     * and return the new instance of `\App\DTOs\NewAccessToken`.
     * 
     * @param string              $name
     * @param array<string,mixed> $morphs
     * @param string[]            $abilities
     * @param DateTimeInterface   $expiresAt
     */
    public function createToken(string $name, array $morphs, array $abilities = ['*'], DateTimeInterface $expiresAt = null): NewAccessToken;
}
