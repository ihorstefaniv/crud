<?php

namespace core;


class RestController
{
    public $route;
    public $controller;
    public $model;
    public $prefix;
    public $data = [];

    public function __construct($route){
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $route['action'];
        $this->prefix = $route['prefix'];
    }

    public function response(){
        $viewObject = json_encode($this->data);
        header("Content-type: application/json; charset=utf-8");
        echo $viewObject;
    }

    public function set($data){
        $this->data = $data;
    }

}