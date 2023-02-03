<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Rest;

use App\Constants\TaskPriorityEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

/**
 * @property-read string $title
 * @property-read string $description
 * @property-read Carbon $due_date
 * @property-read int $priority
 */
class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'due_date'    => ['required', 'date'],
            'priority'    => ['required', 'integer', 'numeric', new Enum(TaskPriorityEnum::class)],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'       => 'Title',
            'description' => 'Description',
            'due_date'    => 'Due Date',
            'priority'    => 'Priority',
        ];
    }
}
