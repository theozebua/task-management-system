<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Contracts\{Arrayable, Jsonable};
use App\Entities\PersonalAccessTokenEntity;

use function json_encode;

class NewAccessToken implements Arrayable, Jsonable
{
    public function __construct(public PersonalAccessTokenEntity $accessToken, public string $plainTextToken)
    {
        // 
    }

    public function toArray(): array
    {
        return [
            'accessToken'    => $this->accessToken,
            'plainTextToken' => $this->plainTextToken,
        ];
    }

    public function toJson(int $options): string
    {
        return json_encode($this->toArray(), $options);
    }
}
