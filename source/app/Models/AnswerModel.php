<?php

namespace App\Models;

use CodeIgniter\Model;

class AnswerModel extends Model
{
    protected $table      = 'answers';
    protected $allowedFields = ['answerBody', 'answerAttachment', 'answerIdentifier', 'answerStatus', 'taskId', 'userId'];

    protected $primaryKey = 'answerId';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $createdField  = 'answerCreatedAt';
    protected $updatedField  = 'answerUpdatedAt';

    protected $useSoftDeletes = false;
    protected $deletedField  = 'answerDeletedAt';
}
