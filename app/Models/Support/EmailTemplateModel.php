<?php

namespace App\Models\Support;

use CodeIgniter\Model;

class EmailTemplateModel extends Model
{
    protected $table = 'emailtemplates';
    protected $primaryKey = 'id';
    protected $allowedFields = ['status', 'subject', 'message'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
