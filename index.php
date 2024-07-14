<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "config/autoload.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// si ma route est en paramètres
$route = $_GET["route"] ?? null;
// j'appelle la fonction route que j'ai créée dans Router.php
$router = new Router();
try {
    $router->route($route);
} catch (JsonException | Exception $e) {
    
}
