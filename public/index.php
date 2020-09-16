<?php

require __DIR__ . '/../vendor/autoload.php';

define('APP_ROOT', __DIR__ . '/../src/');

session_start();

switch($_REQUEST['act'] ?? null) {
    case 'login':
        (new \App\Controller\Login())->execute();
        break;
    case 'logout':
        (new \App\Controller\Logout())->execute();
        break;
    case 'edit':
        (new \App\Controller\Edit())->execute();
        break;
    default:
        (new \App\Controller\Main())->execute();
}