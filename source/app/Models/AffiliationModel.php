<?php

namespace App\Models;

use CodeIgniter\Model;

class AffiliationModel extends Model
{
    protected $table      = 'affiliations';
    protected $allowedFields = ['userId', 'officeId', 'affiliationLevel'];

    protected $primaryKey = 'affiliationId';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $createdField  = 'affiliationCreatedAt';
    protected $updatedField  = 'affiliationUpdatedAt';

    protected $useSoftDeletes = false;
    protected $deletedField  = 'affiliationDeletedAt';
}
