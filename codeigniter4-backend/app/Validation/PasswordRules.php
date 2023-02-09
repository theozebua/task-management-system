<?php

namespace App\Validation;

use App\Entities\UserEntity;
use App\Traits\TokenValidation;
use CodeIgniter\HTTP\ResponseInterface;

class PasswordRules
{
    use TokenValidation;

    public function current_password(string $currentPassword): bool
    {
        $token = $this->validateToken();

        if ($token instanceof ResponseInterface) {
            return $token;
        }

        /** @var UserEntity $user */
        $user = (new $token->tokenable_type)->select(['password'])->find($token->tokenable_id);

        return password_verify($currentPassword, $user->password);
    }
}
