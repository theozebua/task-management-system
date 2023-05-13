<?php

declare(strict_types=1);

namespace App\Validation;

use App\Entities\PersonalAccessTokenEntity;

class PasswordRules
{
    public function current_password(string $currentPassword, ?string &$error = null): bool
    {
        /** @var PersonalAccessTokenEntity $accessToken */
        $accessToken = unserialize(request()->header('access-token')->getValue());

        if (!password_verify(
            $currentPassword,
            (new $accessToken->tokenable_type)
                ->select(['password'])
                ->find($accessToken->tokenable_id)
                ->password
        )) {
            $error = lang('Validation.current_password', ['field' => 'Current Password']);

            return false;
        }

        return true;
    }
}
