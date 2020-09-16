<?php

namespace Lib\Abstracts;

use Lib\Interfaces\ControllerInterface;
use Lib\Renderer;

/**
 * Class AbstractController
 * @package Lib\Abstracts
 */
abstract class AbstractController implements ControllerInterface
{
    /** @var array */
    protected $data = [];

    /** @var array  */
    protected $errors = [];

    /** @var array */
    protected $messages = [];

    /**
     * @return mixed
     */
    final public function execute()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->onSendForm();
        }
        return $this->index();
    }

    /**
     * @param string $name
     */
    protected function display(string $name)
    {
        $this->data['errors'] = $this->errors;
        $this->data['messages'] = $this->messages;
        Renderer::display($name, $this->data);
    }

    /**
     * @return mixed
     */
    abstract public function index();

    /**
     * @return mixed
     */
    abstract public function onSendForm();
}