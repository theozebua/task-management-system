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
        return $this->validate($request->validate());
    }
}
