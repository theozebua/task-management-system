<?php

declare(strict_types=1);

namespace App\Requests\Api\Auth;

use App\Abstracts\FormRequest;

class RegisterRequest extends FormRequest
{
    protected array $attributes = [
        'name',
        'email',
        'password',
        'password_confirmation',
    ];

    protected function rules(): array
    {
        return [
            'name'                  => ['required', 'max_length[255]'],
            'email'                 => ['required', 'valid_email', 'max_length[255]', 'is_unique[users.email]'],
            'password'              => ['required', 'max_length[255]', 'matches[password_confirmation]'],
            'password_confirmation' => ['required', 'matches[password]'],
        ];
    }

    protected function labels(): array
    {
        return [
            'name'                  => 'Name',
            'email'                 => 'Email Address',
            'password'              => 'Password',
            'password_confirmation' => 'Confirm Password',
        ];
    }
}
