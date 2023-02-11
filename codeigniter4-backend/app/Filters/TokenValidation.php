<?php

declare(strict_types=1);

namespace App\Filters;

use App\Entities\PersonalAccessTokenEntity;
use App\Models\PersonalAccessTokenModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\{Header, RequestInterface, Response, ResponseInterface};

use function hash;
use function is_null;
use function preg_replace;
use function response;
use function serialize;
use function str_contains;

class TokenValidation implements FilterInterface
{
    use ResponseTrait;

    private Response $response;

    public function __construct()
    {
        $this->response = response();
    }

    public function before(RequestInterface $request, $arguments = null): ResponseInterface|RequestInterface
    {
        $accessToken = $this->getAccessToken($request);

        return $accessToken instanceof ResponseInterface
            ? $accessToken
            : $request->appendHeader('access-token', serialize($accessToken));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): mixed
    {
        //
    }

    private function getAccessToken(RequestInterface $request): PersonalAccessTokenEntity|ResponseInterface
    {
        $token = $this->validateToken(authorization: $request->header('Authorization'));

        return $token instanceof ResponseInterface
            ? $token
            : ((new PersonalAccessTokenModel())
                ->select(['id', 'tokenable_id', 'tokenable_type', 'token'])
                ->where('token', hash('sha256', $token))
                ->first() ?: $this->failUnauthorized());
    }

    private function validateToken(array|Header|null $authorization): string|ResponseInterface
    {
        return !is_null($authorization) && str_contains($token = $authorization->getValue(), 'Bearer ')
            ? preg_replace('/Bearer \d+\|/', '', $token)
            : $this->failUnauthorized();
    }
}
