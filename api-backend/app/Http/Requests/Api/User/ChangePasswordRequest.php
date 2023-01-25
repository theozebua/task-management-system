<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property-read string $old_password
 * @property-read string $password
 * @property-read string $password_confirmation
 */
class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'current_password'      => ['required', 'current_password', 'max:255'],
            'password'              => ['required', 'confirmed', 'max:255'],
            'password_confirmation' => ['required', 'same:password', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password'      => 'Current Password',
            'password'              => 'Password',
            'password_confirmation' => 'Confirm Password',
        ];
    }
}
