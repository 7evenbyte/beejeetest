<?php

namespace Lib;

/**
 * Class Renderer
 * @package Lib
 */
final class Renderer
{
    /** @var \Smarty */
    private static $instance = null;

    /**
     * @return \Smarty|null
     */
    private static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new \Smarty();
            static::$instance->setTemplateDir(APP_ROOT . 'View');
            static::$instance->setCacheDir(APP_ROOT . '../var/cache/');
            static::$instance->setCompileDir(APP_ROOT . '../var/compiled/');
        }

        return static::$instance;
    }

    /**
     * @param string $name
     * @param array $parameters
     */
    public static function display(string $name, $parameters = [])
    {
        if (count($parameters)) {
            array_walk($parameters, function($value, $name) {
                self::getInstance()->assign($name, $value);
            });
        }
        try {
            self::getInstance()->display($name);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit(1);
        }
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return bool|string
     */
    public static function fetch(string $name, $parameters = [])
    {
        if (count($parameters)) {
            array_walk($parameters, function($value, $name) {
                self::getInstance()->assign($name, $value);
            });
        }
        try {
            return self::getInstance()->fetch($name);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit(1);
        }
    }
}