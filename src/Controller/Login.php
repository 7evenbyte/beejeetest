<?php

namespace App\Controller;

use Lib\Abstracts\AbstractController;

/**
 * Class Login
 * @package App\Controller
 */
class Login extends AbstractController
{
    public function index()
    {
        if (null !== ($_SESSION['is_admin'] ?? null)) {
            header('location: /');
            exit(0);
        }
        $this->display('login.tpl');
    }

    public function onSendForm()
    {
        if (empty($_POST['login'])) {
            $this->errors['login_error'] = 'Необходимо указать логин';
        } elseif ($_POST['login'] != 'admin') {
            $this->errors['login_error'] = 'Неправильный логин';
        }

        if (empty($_POST['password'])) {
            $this->errors['password_error'] = 'Необходимо указать пароль';
        } elseif ($_POST['password'] != '123') {
            $this->errors['password_error'] = 'Неправильный пароль';
        }

        if (!count($this->errors)) {
            setcookie('session_id', session_id(), time() + time() * 24);
            session_start();
            $_SESSION['is_admin'] = true;
        }

        return $this->index();
    }
}