<?php

declare(strict_types=1);

namespace App\Models;

use App\Constants\TaskPriorityEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int              $id
 * @property int              $user_id
 * @property string           $title
 * @property string           $description
 * @property Carbon           $due_date
 * @property TaskPriorityEnum $priority
 * @property bool             $is_finished
 * @property Carbon           $created_at
 * @property Carbon           $updated_at
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
