<?php

class Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Model();
    }
}