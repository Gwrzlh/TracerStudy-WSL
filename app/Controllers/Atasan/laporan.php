<?php

namespace App\Controllers\Atasan;

use App\Models\LandingPage\LaporanModel;
use App\Controllers\BaseController;

class Laporan extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    public function index()
    {
        // Ambil laporan terbaru
        $laporan = $this->laporanModel->orderBy('id', 'DESC')->first();

        return view('landingpage/laporan', [
            'laporan' => $laporan
        ]);
    }
}
