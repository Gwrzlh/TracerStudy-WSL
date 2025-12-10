<?php

namespace App\Controllers\LandingPage;

use App\Models\LandingPage\TentangModel;
use App\Controllers\BaseController;

class LandingPage extends BaseController
{
    protected $tentangModel;

    public function __construct()
    {
        $this->tentangModel = new TentangModel();
    }

    public function home()
    {
        return view('LandingPage/Homepage');
    }

    public function sop()
    {
        $data['tentang'] = $this->tentangModel->first();
        return view('LandingPage/sop', $data);
    }
    
    
}
