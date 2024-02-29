<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php-api-rest/Config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php-api-rest/Controllers/EmployerController.php';

$method = $_SERVER['REQUEST_METHOD'];

// Procesa la solicitud según el método

switch ($method) {
    case 'GET':
        $employer = new EmployerController();
        // Obtiene un empleador
        if(isset($_GET['id'])){
            $employer->readSingle($_GET['id']);
        } else {
            // Obtiene todos los empleadores
            $employer->read();
        }
        break;
    case 'POST':
        $employer = new EmployerController();
        //Crea un nuevo empleador
        $employer->create();
        break;
    case 'PUT':
        $employer = new EmployerController();
        //Actualiza datos de empleador
        $employer->update();
        break;
    case 'DELETE':
        if(isset($_GET['id'])){
            $employer = new EmployerController();
            // Elimina un empleador
            $employer->delete($_GET['id']);
        } else {
            echo json_encode(array("message" => "No employer id provided."));
        }
        break;
    default:
        // Método no valido
        echo "Metodo no valido";
        break;
}