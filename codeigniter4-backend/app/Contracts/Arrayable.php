<?php

declare(strict_types=1);

namespace App\Contracts;

interface Arrayable
{
    /**
     * Convert to Array.
     * 
     * @return array
     */
    public function toArray(): array;
}
