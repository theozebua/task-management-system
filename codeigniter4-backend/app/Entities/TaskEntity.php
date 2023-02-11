<?php

declare(strict_types=1);

namespace App\Entities;

use App\Constants\TaskPriorityEnum;
use App\Entities\Cast\TaskPriorityCast;
use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

/**
 * @property int              $id
 * @property int              $user_id
 * @property string           $title
 * @property string           $description
 * @property Time             $due_date
 * @property TaskPriorityEnum $priority
 * @property bool             $is_finished
 * @property Time             $created_at
 * @property Time             $updated_at
 */
class TaskEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'due_date'];
    protected $casts   = [
        'id'          => 'integer',
        'user_id'     => 'integer',
        'priority'    => 'taskpriorityenum',
        'is_finished' => 'boolean',
    ];
    protected $castHandlers = [
        'taskpriorityenum' => TaskPriorityCast::class,
    ];
}
