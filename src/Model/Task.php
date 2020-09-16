<?php

namespace App\Model;

use Lib\MysqlPDO;

/**
 * Class Task
 * @package App\Model
 */
class Task
{
    /** @var */
    private $data;

    /**
     * Task constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->data['task_id'];
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->data['name'] = $name;
        return $this;
    }

    /**
     * @return bool|mixed
     */
    public function getName()
    {
        return $this->data['name'] ?? false;
    }

    /**
     * @param string $author
     * @return $this
     */
    public function setEmail(string $author)
    {
        $this->data['email'] = $author;
        return $this;
    }

    /**
     * @return bool|mixed
     */
    public function getEmail()
    {
        return $this->data['email'] ?? false;
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody(string $body)
    {
        $body = htmlspecialchars($body);
        if ($body != $this->data['body']) {
            $this->data['is_modified'] = 1;
        }
        $this->data['body'] = $body;
        return $this;
    }

    /**
     * @return bool|mixed
     */
    public function getBody()
    {
        return $this->data['body'] ?? false;
    }

    /**
     * @param $complete
     * @return $this
     */
    public function setStatus($complete)
    {
        $this->data['status'] =  $complete;
        return $this;
    }

    public function getStatus()
    {
        return $this->data['status'] ?? 0;
    }

    public function modifiedByAdmin()
    {
        if ($this->data['is_modified'] != 0) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function update()
    {
        $stmt = MysqlPDO::getConnection()->prepare(
            'UPDATE task SET name = :name, email = :email, body = :body, status = :status, is_modified = :is_modified WHERE task_id = :id'
        );

        $stmt->bindValue(':name', $this->data['name']);
        $stmt->bindValue(':email', $this->data['email']);
        $stmt->bindValue(':body', $this->data['body']);
        $stmt->bindValue(':status', $this->data['status']);
        $stmt->bindValue(':is_modified', $this->data['is_modified'] ?? 0);
        $stmt->bindValue(':id', $this->data['task_id']);

        return $stmt->execute();
    }
}