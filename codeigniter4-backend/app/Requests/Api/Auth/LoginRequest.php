<?php

declare(strict_types=1);

namespace App\Requests\Api\Auth;

use App\Abstracts\FormRequest;

class LoginRequest extends FormRequest
{
    protected array $attributes = [
        'email',
        'password',
    ];

    protected function rules(): array
    {
        return [
            'email'    => ['required', 'valid_email'],
            'password' => ['required'],
        ];
    }

    protected function label(): array
    {
        return [
            'email'    => 'Email Address',
            'password' => 'Password',
        ];
    }
}
