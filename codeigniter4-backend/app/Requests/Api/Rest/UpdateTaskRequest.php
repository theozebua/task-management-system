<?php

declare(strict_types=1);

namespace App\Requests\Api\Rest;

use App\Abstracts\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    protected array $attributes = [
        'title',
        'description',
        'due_date',
        'priority',
        'is_finished',
    ];

    protected function rules(): array
    {
        return [
            'title'       => ['required', 'max_length[255]'],
            'description' => [],
            'due_date'    => ['required', 'valid_date'],
            'priority'    => ['required', 'integer', 'numeric', 'valid_priority'],
            'is_finished' => ['boolean'],
        ];
    }

    protected function labels(): array
    {
        return [
            'title'       => 'Title',
            'description' => 'Description',
            'due_date'    => 'Due Date',
            'priority'    => 'Priority',
            'is_finished' => 'Is Finished',
        ];
    }
}
