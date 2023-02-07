<?php

declare(strict_types=1);

namespace App\Traits;

use App\Contracts\FormRequestContract;

trait Validation
{
    /**
     * Validate the request.
     * 
     * @param FormRequestContract $request
     * 
     * @return bool
     */
    private function validation($request): bool
    {
        $this->validate($request->validate());

        return $this->validator->withRequest($this->request)->run();
    }
}
