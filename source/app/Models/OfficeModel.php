<?php

namespace App\Models;

use CodeIgniter\Model;

class OfficeModel extends Model
{
    protected $table      = 'offices';
    protected $allowedFields = ['officeName', 'officeDescription', 'officeIdentifier', 'officeInvitationCode'];

    protected $primaryKey = 'officeId';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $createdField  = 'officeCreatedAt';
    protected $updatedField  = 'officeUpdatedAt';

    protected $useSoftDeletes = false;
    protected $deletedField  = 'officeDeletedAt';
}
