<?php

namespace App\Controller;

abstract class BaseController
{
    protected function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . '/../View/templates/header.php';
        include __DIR__ . '/../View/' . $view . '.php';
        include __DIR__ . '/../View/templates/footer.php';
    }
}
