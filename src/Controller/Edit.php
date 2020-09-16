<?php

namespace App\Controller;

use App\Model\Task;
use Lib\Abstracts\AbstractController;
use Lib\MysqlPDO;

/**
 * Class Edit
 * @package App\Controller
 */
class Edit extends AbstractController
{
    public function __construct()
    {
        $stmt = MysqlPDO::getConnection()->prepare(
            'SELECT task_id, name, email, body, status, is_modified FROM task WHERE task_id = :id'
        );

        $stmt->bindValue(':id', $_REQUEST['id'] ?? 0);
        if ($stmt->execute()) {
            $this->data['task'] = new Task($stmt->fetch(\PDO::FETCH_ASSOC));
        }
    }

    public function index()
    {
        $this->checkAdminAccess();
        $this->display('edit.tpl');
    }

    public function onSendForm()
    {
        $this->checkAdminAccess();
        $this->data['task']->setName($_REQUEST['name']);
        $this->data['task']->setEmail($_REQUEST['email']);
        $this->data['task']->setBody($_REQUEST['body']);
        $this->data['task']->setStatus($_REQUEST['status']);

        if ($this->data['task']->update()) {
            header('location: /');
            exit(0);
        }
    }

    /**
     * Redirect to login page if not granted access
     */
    private function checkAdminAccess()
    {
        if (null === ($_SESSION['is_admin'] ?? null)) {
            header('location: /?act=login');
            exit(0);
        }
    }
}