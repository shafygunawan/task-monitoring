<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table      = 'tasks';
    protected $allowedFields = ['taskTitle', 'taskDescription', 'taskDeadlines', 'taskIdentifier', 'officeId', 'affiliationId'];

    protected $primaryKey = 'taskId';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $createdField  = 'taskCreatedAt';
    protected $updatedField  = 'taskUpdatedAt';

    protected $useSoftDeletes = false;
    protected $deletedField  = 'taskDeletedAt';
}
