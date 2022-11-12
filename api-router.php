<?php
require_once './libs/Router.php';
require_once './app/controllers/muralsApiController.php';

// crea el router
$router = new Router();

// defino la tabla de ruteo
    
$router->addRoute('murals', 'GET', 'MuralsApiController', 'gets');
$router->addRoute('murals/:ID', 'GET', 'MuralsApiController', 'get');
$router->addRoute('murals/:ID', 'DELETE', 'MuralsApiController', 'delete');
$router->addRoute('murals', 'POST', 'MuralsApiController', 'insert');


// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);