<?php

declare(strict_types=1);

namespace App\Controllers\Api\Auth;

use App\Controllers\BaseController;
use App\Entities\PersonalAccessTokenEntity;
use App\Models\PersonalAccessTokenModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

use function hash;
use function preg_replace;
use function request;
use function response;
use function str_contains;

class LogoutController extends BaseController
{
    use ResponseTrait;

    public function __construct(private PersonalAccessTokenModel $personalAccessTokenModel = new PersonalAccessTokenModel())
    {
        //
    }

    public function handle(): ResponseInterface
    {
        $authorization = request()->header('Authorization');
        $token         = $authorization->getValue();

        if (!$authorization || !str_contains($token, 'Bearer ')) {
            return $this->failUnauthorized();
        }

        $accessToken = $this->validateToken($token);

        if (!$accessToken) {
            return $this->failUnauthorized();
        }

        $this->personalAccessTokenModel->delete($accessToken->id);

        return response()->setStatusCode(response()::HTTP_NO_CONTENT);
    }

    private function validateToken(string $token): ?PersonalAccessTokenEntity
    {
        $plainTextToken = preg_replace('/Bearer \d+\|/', '', $token);

        return $this->personalAccessTokenModel->select(['id', 'token'])->where('token', hash('sha256', $plainTextToken))->first();
    }
}
