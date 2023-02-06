<?php

declare(strict_types=1);

namespace App\Traits;

use App\Contracts\FormRequest;

trait Validation
{
    /**
     * Validate the request.
     * 
     * @param FormRequest $request
     * 
     * @return bool
     */
    private function validation($request): bool
    {
        [
            'rules'    => $rules,
            'messages' => $messages,
        ] = $request->validate();

        $this->validate($rules, $messages);

        return $this->validator->withRequest($this->request)->run();
    }
}
