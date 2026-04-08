<?php

spl_autoload_register(function($class){
    $class = str_replace("App\\","",$class);
    $file = __DIR__ . "/../src/" . str_replace("\\","/",$class) . ".php";

    if (file_exists($file)) {
        require $file;
    }
});

use App\Container\AppFactory;

$ctrl = AppFactory::createController();

$res = $ctrl->handle([
    "action"=>"create_filiere",
    "code"=>"info2",
    "libelle"=>"Informatique"
]);

var_dump($res);