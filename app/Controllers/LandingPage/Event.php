<?php

namespace App\Controllers\LandingPage;

use App\Controllers\BaseController;
use App\Models\LandingPage\TentangModel;

class Event extends BaseController
{
    protected $tentangModel;

    public function __construct()
    {
        $this->tentangModel = new TentangModel();
    }

    public function index()
    {
        // Data event (bisa nanti diganti ambil dari DB)
        $tentang = [
            'judul3'  => 'Event Tracer Study',
            'isi3'    => 'Daftar event terbaru ...',
            'gambar2' => '' // pastikan selalu ada untuk menghindari error
        ];

        return view('LandingPage/event', compact('tentang'));
    }
}