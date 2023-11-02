<?php

namespace app\core;

class Router
{
    protected $params = [];

    public function math()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        var_dump($url);
    }

    public function run()
    {
        if ($this->math()) {
            $path_controller = 'app\\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path_controller)){
                $action = 'action' . ucfirst($this->params['action']);
                if (method_exists($path_controller, $action)){
                    $controller = new $path_controller;
                    $controller->$action();
                } else {
                    echo 'Action не найден: '. $action;
                }
            } else {
                echo 'Класс не найден: ' . $path_controller;
            }
        } else{
            echo 'Мы потерялись!';
        }
    }

    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        if (!empty($url)) {
            $params = explode('/', $url);
            if (!empty($params[0] && !empty($params[1]))) {
                $this->params = [
                    'controller' => $params[0],
                    'action' => $params[1]
                ];
            } else {
                return false;
            }
        } else {
            $this->params = [
                'controller' => 'main',
                'action' => 'index'
            ];
        }
    }

}
