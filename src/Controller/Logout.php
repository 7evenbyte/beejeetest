<?php

namespace App\Controller;

use Lib\Abstracts\AbstractController;

/**
 * Class Logout
 * @package App\Controller
 */
class Logout extends AbstractController
{
    /**
     * @return mixed|void
     */
    public function index()
    {
        if (isset($_SESSION['is_admin'])) {
            session_destroy();
        }

        header('location: /');
        exit(0);
    }

    /**
     * @return mixed|void
     */
    public function onSendForm()
    {
        return $this->index();
    }
}