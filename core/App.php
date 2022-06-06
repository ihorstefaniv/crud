<?php

namespace core;

class App
{
    public static $app;

    public function __construct(){
        $query = trim($_SERVER['QUERY_STRING'], '/');
      
        new ErrorHandler();
        Router::dispatch($query);
    }

}