<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table      = 'comments';
    protected $allowedFields = ['commentBody', 'taskId', 'userId'];

    protected $primaryKey = 'commentId';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $createdField  = 'commentCreatedAt';
    protected $updatedField  = 'commentUpdatedAt';

    protected $useSoftDeletes = false;
    protected $deletedField  = 'commentDeletedAt';
}
