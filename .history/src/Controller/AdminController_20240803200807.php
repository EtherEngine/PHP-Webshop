<?php

namespace App\Controller;

class AdminController extends BaseController
{
    public function dashboard()
    {
        // Logik zum Admin-Dashboard
        $this->render('admin/dashboard', ['stats' => $stats]);
    }
}
