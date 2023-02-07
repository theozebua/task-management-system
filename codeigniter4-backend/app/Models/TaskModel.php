<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\TaskEntity;
use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table         = 'tasks';
    protected $returnType    = TaskEntity::class;
    protected $allowedFields = [
        'user_id',
        'title',
        'description',
        'due_date',
        'priority',
        'is_finished',
    ];
    protected $useTimestamps = true;
}
