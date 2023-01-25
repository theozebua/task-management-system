<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property-read string $name
 * @property-read string $email
 * @property-read string $password
 * @property-read string $password_confirmation
 */
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guest();
    }

    public function rules(): array
    {
        return [
            'name'                  => ['required', 'max:255'],
            'email'                 => ['required', 'email:rfc,dns', 'unique:users,email', 'max:255'],
            'password'              => ['required', 'confirmed', 'max:255'],
            'password_confirmation' => ['required', 'max:255', 'same:password'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'                  => 'Name',
            'email'                 => 'Email Address',
            'password'              => 'Password',
            'password_confirmation' => 'Confirm Password',
        ];
    }
}
