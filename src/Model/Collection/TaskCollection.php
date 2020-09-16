<?php

namespace App\Model\Collection;

use App\Model\Task;
use Lib\MysqlPDO;

/**
 * Class TaskCollection
 * @package App\Model\Collection
 */
class TaskCollection
{
    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';

    /** @var int */
    private $limit;

    /** @var string */
    private $sort;

    /** @var string */
    private $sortBy;

    /** @var int */
    private $page;

    /**
     * TaskCollection constructor.
     * @param int $page
     * @param string $sort
     * @param string $sort_by
     * @param int $limit
     */
    public function __construct($page = 0, $sort = self::SORT_ASC, $sort_by = 'task_id',  $limit = 3)
    {
        $this->limit = $limit;
        $this->sort = $sort;
        $this->sortBy = $sort_by;
        $this->page = $page;
    }

    public function getTasksList()
    {
        $pagesCount = $this->getPagesCount();
        $startFrom = $this->page * $this->limit - $this->limit;
        if ($startFrom < 0) {
            $startFrom = 0;
        }
        /** Get tasks from table */
        $stmt = MysqlPDO::getConnection()->prepare(
            'SELECT 
                            task_id, 
                            name, 
                            email, 
                            body, 
                            status, 
                            is_modified 
                        FROM task ORDER BY '.$this->sortBy.' '.$this->sort.' LIMIT :startFrom, :limit',
            [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]
        );

        $stmt->bindValue(':startFrom', $startFrom, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $this->limit, \PDO::PARAM_INT);

        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            exit(1);
        }

        $tasks = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT)) {
            $tasks[] = new Task($row);
        }
        $stmt = null;

        return $tasks;
    }

    /**
     * Return total count of tasks
     *
     * @return int|mixed
     */
    private function getTotalTasks()
    {
        $stmt = MysqlPDO::getConnection()->query('SELECT count(task_id) as count FROM task');
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'] ?? 0;
    }

    /**
     * @return false|float
     */
    public function getPagesCount()
    {
        /** Get total count of tasks and make pages enum */
        return ceil($this->getTotalTasks() / $this->limit);
    }
}