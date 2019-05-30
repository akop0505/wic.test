<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once "services/service.php";

use core\Request;

spl_autoload_register(function ($class){
    $path = str_replace('\\','/',$class.".php");
    if(file_exists($path)){
        require $path;
    }
});

$request = new Request();
$request->run();