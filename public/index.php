<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require '../vendor/autoload.php';
require_once('../app/Utils/Router.php');
require_once('../app/Controllers/UserController.php');

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

$router = new \app\Utils\Router;
$users = new app\Controllers\UserController();

/**
 * Show all users
 */
$router->registerRoute('GET', '^/users$', function() use($users){
    echo json_encode($users->index());
});

/**
 * show user with id xx
 */
$router->registerRoute('GET', '^/users/(?<id>\d+)$', function($params) use($users){
    echo json_encode($users->getById($params['id']));
});

/**
 * create new user
 */
$router->registerRoute('POST', '^/users$', function() use($users){
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    echo json_encode($users->store($data));
});

/**
 * update user
 */
$router->registerRoute('POST', '^/users/(?<id>\d+)$', function($params) use($users){
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    echo json_encode($users->update($params['id'], $data));
});

/**
 * delete user
 */
$router->registerRoute('DELETE', '^/users/(?<id>\d+)$', function($params) use($users){
    echo json_encode($users->destroy($params['id']));
});