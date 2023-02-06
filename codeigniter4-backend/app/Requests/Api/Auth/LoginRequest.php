<?php

declare(strict_types=1);

namespace App\Requests\Api\Auth;

use App\Contracts\FormRequest;

class LoginRequest implements FormRequest
{
    public function validate(): array
    {
        return [
            'rules'    => $this->rules(),
            'messages' => $this->messages(),
        ];
    }

    private function rules(): array
    {
        return [
            'email'    => ['required', 'valid_email'],
            'password' => ['required'],
        ];
    }

    private function messages(): array
    {
        return [
            'email'    => [
                'required'    => 'The Email Address field is required.',
                'valid_email' => 'The Email Address must be a valid email address.',
            ],
            'password' => [
                'required'    => 'The Email Address field is required.',
            ],
        ];
    }
}
