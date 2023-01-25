<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TaskResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var self|Task $this */
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'due_date'    => $this->due_date->diffForHumans(),
            'priority'    => Str::ucfirst(Str::lower($this->priority->name)),
            'is_finished' => (bool) $this->is_finished,
            'created_at'  => $this->created_at->diffForHumans(),
            'updated_at'  => $this->updated_at->diffForHumans(),
        ];
    }
}
