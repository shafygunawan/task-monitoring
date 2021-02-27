<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $allowedFields = ['userFirstName', 'userLastName', 'userEmail', 'userPassword'];

    protected $primaryKey = 'userId';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $createdField  = 'userCreatedAt';
    protected $updatedField  = 'userUpdatedAt';

    protected $useSoftDeletes = false;
    protected $deletedField  = 'userDeletedAt';
}
