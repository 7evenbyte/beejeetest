<?php

namespace Lib\Interfaces;

/**
 * Interface ControllerInterface
 * @package Lib\Interfaces
 */
interface ControllerInterface
{
    /**
     * Default action for controller
     *
     * @return mixed
     */
    public function index();

    /**
     * Execute this when request method is POST
     *
     * @return mixed
     */
    public function onSendForm();
}