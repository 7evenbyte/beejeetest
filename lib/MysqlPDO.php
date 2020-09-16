<?php

namespace Lib;

/**
 * Class MysqlPDO
 * @package Lib
 */
class MysqlPDO
{
    /** @var \PDO */
    private static $connection = null;

    /**
     * @return \PDO|null
     */
    public static function getConnection()
    {
        if (null === static::$connection) {
            try {
                static::$connection = new \PDO('mysql:host=localhost;dbname=test', 'root', 'adminpassword');
            } catch (\Exception $e) {
                echo $e->getMessage();
                exit(1);
            }
        }

        return static::$connection;
    }
}