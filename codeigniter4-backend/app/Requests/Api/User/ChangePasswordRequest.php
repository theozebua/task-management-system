<?php

declare(strict_types=1);

namespace App\Requests\Api\User;

use App\Abstracts\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    protected array $attributes = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected function rules(): array
    {
        return [
            'current_password'      => ['required', 'current_password'],
            'password'              => ['required', 'matches[password_confirmation]', 'max_length[255]'],
            'password_confirmation' => ['required', 'matches[password]', 'max_length[255]'],
        ];
    }

    protected function labels(): array
    {
        return [
            'current_password'      => 'Current Password',
            'password'              => 'Password',
            'password_confirmation' => 'Confirm Password',
        ];
    }
}
