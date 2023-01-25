<?php

declare(strict_types=1);

namespace App\Models;

use App\Constants\TaskPriorityEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property-read string $title
 * @property-read string $description
 * @property-read Carbon $due_date
 * @property-read TaskPriorityEnum $priority
 * @property-read bool $is_finished
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Task extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'due_date' => 'datetime',
        'priority' => TaskPriorityEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
