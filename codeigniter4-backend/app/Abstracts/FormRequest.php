<?php

declare(strict_types=1);

namespace App\Abstracts;

use App\Contracts\FormRequestContract;

abstract class FormRequest implements FormRequestContract
{
    protected array $attributes;

    public function validate(): array
    {
        foreach ($this->attributes as $attribute) {
            $rules[$attribute] = [
                'label' => $this->label()[$attribute],
                'rules' => $this->rules()[$attribute],
            ];
        }

        return $rules;
    }

    abstract protected function label(): array;

    abstract protected function rules(): array;
}
