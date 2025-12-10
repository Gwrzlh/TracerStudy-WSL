<?php

namespace App\Models\Alumni;

use CodeIgniter\Model;

class PerusahaanAlumni extends Model
{
    protected $table = 'perusahaan_alumni';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_perusahaan', 'id_alumni', 'tanggal_ditambahkan'];
    public $useTimestamps = false;
}
