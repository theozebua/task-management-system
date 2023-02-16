<?php

declare(strict_types=1);

namespace App\Contracts;

interface FormRequestContract
{
    /**
     * Return the validation rules and error messages.
     * 
     * @return array<string,array<string,string[]>>
     */
    public function validate(): array;
}
