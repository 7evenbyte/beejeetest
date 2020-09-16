<?php

namespace App\Controller;

use App\Model\Collection\TaskCollection;
use Lib\Abstracts\AbstractController;
use Lib\MysqlPDO;

/**
 * Class Main
 * @package App\Controller
 */
class Main extends AbstractController
{
    public function index()
    {
        $sort = 'ASC';
        if (isset($_REQUEST['sort'])) {
            switch($_REQUEST['sort']) {
                default:
                case 'asc':
                    $sort = 'ASC';
                    $this->data['sort'] = 'desc';
                    break;

                case 'desc':
                    $sort = 'DESC';
                    $this->data['sort'] = 'asc';
                    break;
            }
        }
        $taskCollection = new TaskCollection($_REQUEST['page'] ?? 0, $sort, $_REQUEST['sort_by'] ?? 'task_id');
        $this->data['tasks'] = $taskCollection->getTasksList();
        $this->data['pages'] = $taskCollection->getPagesCount();
        $this->display('index.tpl');
    }

    public function onSendForm()
    {
        preg_match('/([a-zA-Z-_]+\@[a-zA-Z-_]+\.[a-z]{2,})/m', $_POST['email'], $matches);
        if (!count($matches)) {
            $this->errors['email_error'] = 'Некорректный адрес электронной почты.';
        }

        if (empty($_POST['name'])) {
            $this->errors['name_error'] = 'Необходимо указать имя пользователя';
        }

        if (empty($_POST['body'])) {
            $this->errors['body_error'] = 'Необходимо указать описание задачи';
        }

        if (empty($_POST['name']) && empty($_POST['email']) && empty($_POST['body'])) {
            $this->errors['form_empty'] = 'Необходимо заполнить все поля';
        }

        if (!count($this->errors)) {
            $stmt = MysqlPDO::getConnection()->prepare(
                'INSERT INTO task (name, email, body, status) VALUES (:name, :email, :body, :status)'
            );

            $stmt->bindValue(':name', htmlspecialchars($_POST['name']));
            $stmt->bindValue(':email', htmlspecialchars($_POST['email']));
            $stmt->bindValue(':body', htmlspecialchars($_POST['body']));
            $stmt->bindValue(':status', 0, \PDO::PARAM_INT);

            if ($stmt->execute()) {
                if ($id = MysqlPDO::getConnection()->lastInsertId()) {
                    $this->messages['create_success'] = 'Новая задача успешно создана';
                }
            }
        }

        return $this->index();
    }
}