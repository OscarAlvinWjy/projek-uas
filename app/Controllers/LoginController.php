<?php

namespace App\Controllers;

class LoginController extends BaseController
{
    public function index(): string
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        return view('loginView');
    }
}
