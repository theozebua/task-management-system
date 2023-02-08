<?php

declare(strict_types=1);

namespace App\Controllers\Api\Auth;

use App\Controllers\BaseController;
use App\Models\PersonalAccessTokenModel;
use App\Traits\TokenValidation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

use function response;

class LogoutController extends BaseController
{
    use ResponseTrait, TokenValidation;

    public function __construct(private PersonalAccessTokenModel $personalAccessTokenModel = new PersonalAccessTokenModel())
    {
        //
    }

    public function handle(): ResponseInterface
    {
        $token = $this->validateToken();

        if ($token instanceof ResponseInterface) {
            return $token;
        }

        $this->personalAccessTokenModel->delete($token->id);

        return response()->setStatusCode(response()::HTTP_NO_CONTENT);
    }
}
