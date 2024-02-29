<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php-api-rest/Config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php-api-rest/Controllers/UserController.php';

$method = $_SERVER['REQUEST_METHOD'];

// Procesa la solicitud según el método
switch ($method) {
    case 'GET':
        $user = new UserController();
        // Obtiene un usuario
        if(isset($_GET['id'])){
            $user->readOne($_GET['id']);
        } else {
            // Obtiene todos los usuarios
            $user->read();
        }
        break;
    case 'POST':
        $user = new UserController();
        if(isset($_GET['login'])) {
            //Login de usuarios
            $user->login();
        } else {
            //Crea un nuevo usuario
            $user->create();
        }
        break;
    case 'PUT':
        $user = new UserController();
        //Actualiza el token de usuario
        if(isset($_GET['update']) && $_GET['update'] === 'token') {
            $user->updateToken();
        } else {
        //Actualiza datos de Usuario
            $user->update();
        }
        break;
    case 'DELETE':
        if(isset($_GET['id'])){
            $user = new UserController();
            // Elimina un usuario
            $user->delete($_GET['id']);
        } else {
            echo json_encode(array("message" => "No user id provided."));
        }
        break;
    default:
        // Método no valido
        echo "Metodo no valido";
        break;
}