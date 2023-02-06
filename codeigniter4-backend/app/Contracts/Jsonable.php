<?php

declare(strict_types=1);

namespace App\Contracts;

interface Jsonable
{
    /**
     * Convert to JSON.
     * 
     * @param int $options
     * 
     * @return string
     */
    public function toJson(int $options): string;
}
