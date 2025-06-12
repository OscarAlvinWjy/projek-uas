<?php

namespace App\Controllers;

class contohdoank extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
}
