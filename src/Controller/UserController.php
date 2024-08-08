<?php

namespace App\Controller;

class UserController extends BaseController
{
    public function profile()
    {
        // Logik zum Benutzerprofil
        $this->render('partials/user_profile', ['user' => $user]);
    }
}
