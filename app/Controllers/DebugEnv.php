<?php

namespace App\Controllers;

class DebugEnv extends BaseController
{
    public function index()
    {
           dd([
                'env' => env('BREVO_API_KEY'),
                'smtp' => env('email.SMTPHost'),
                'ci_env' => env('CI_ENVIRONMENT'),
            ]);


    }
}
