<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once $_SERVER['DOCUMENT_ROOT'] . '/php-api-rest/Config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php-api-rest/Model/User.php';

class UserController {
    private $database;
    private $db;
    private $items;

    public function __construct(){
        $this->database = new Database();
        $this->db = $this->database->getConnection();
        $this->items = new User($this->db);
    }

    //Login user
    public function login() {
        header("Access-Control-Allow-Methods: POST");
        $json = file_get_contents("php://input");
        $data = json_decode($json);

        if(!isset($data->username) || !isset($data->password)) {
            http_response_code(400);
            echo json_encode(['error' => 'Please provide username and password']);
            return;
        }
        //Consulta username
        $user = $this->items->getUserByUsername($data->username);
        if(!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'Wrong username']);
            return;
        }
        //Verifica contraseña
        if(!password_verify($data->password, $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Wrong password']);
            return;
        }
        //inicia una sesion
        session_start();
        //almacena info de usuario en la sesion
        $_SESSION['user'] = $user['username'];
        $_SESSION['token'] = $user['api_token'];
        //devuelve el token
        http_response_code(200);
        echo json_encode([
            'token' => $user['api_token']
        ]);
    }
    //Read all users
    public function read() {
        header("Access-Control-Allow-Methods: GET");

        $stmt = $this->items->getUsers();
        $itemCount = $stmt->rowCount();
        //echo json_encode($itemCount);

        if($itemCount > 0) {
            $userData = array();
            $userData["data"] = array();
            $userData["itemCount"] = $itemCount;

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $u = array(
                    "id" => $id,
                    "username" => $username,
                    "password" => $password,
                    "email" => $email,
                    "role" => $role,
                    "photo" => $photo,
                    "api_token" => $api_token,
                    "created_at" => $created_at,
                    "updated_at" => $updated_at
                );
                array_push($userData["data"], $u);
            }
            echo json_encode($userData);
        } else {
            http_response_code(404);
            echo json_encode(
                array("message" => "No record found.")
            );
        }
    }
    //Read one user
    public function readOne($id) {
        header("Access-Control-Allow-Methods: GET");

        $this->items->id = isset($_GET['id']) ? $_GET['id'] : die();
        $this->items->getUser($id);

        if ($this->items->username != null) {
            //create array
            $user_data = array(
                "id" =>  $this->items->id,
                "username" => $this->items->username,
                "password" => $this->items->password,
                "email" => $this->items->email,
                "role" => $this->items->role,
                "photo" => $this->items->photo,
                "api_token" => $this->items->api_token,
                "created_at" => $this->items->created_at,
                "updated_at" => $this->items->updated_at
            );
        
            http_response_code(200);
            echo json_encode($user_data);
        } else {
            http_response_code(404);
            echo json_encode("User not found.");
        }
    }
    //Create user
    public function create() {
        header("Access-Control-Allow-Methods: POST");

        $data = json_decode(file_get_contents("php://input"));
        $this->items->username = $data->username;
        $this->items->password = $data->password;
        $this->items->email = $data->email;
        $this->items->role = $data->role;
        //$this->items->api_token = $data->api_token;

        if($this->items->createUser()) {
            http_response_code(200);
            echo json_encode(array("message" => "User was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create user."));
        }
    }
    //Update user
    public function update() {
        header("Access-Control-Allow-Methods: PUT");

        $data = json_decode(file_get_contents("php://input"));
        //reference id sent by body
        $this->items->id = $data->id;

        //user values
        $this->items->username = $data->username;
        $this->items->password = $data->password;
        $this->items->email = $data->email;
        $this->items->role = $data->role;

        if($this->items->updateUser()) {
            http_response_code(200);
            echo json_encode(array("message" => "User was updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update user."));
        }
    }
    //Update user api_token
    public function updateToken() {
        header("Access-Control-Allow-Methods: PUT");

        $data = json_decode(file_get_contents("php://input"));
        //reference id sent by body
        $this->items->id = $data->id;
        //user values
        //$this->items->api_token = $data->api_token;

        //Update user api token
        if($this->items->updateApiToken()) {
            http_response_code(200);
            echo json_encode(array("message" => "User Api Token was updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update user Api Token."));
        }
    }
    //Delete user
    public function delete($id) {
        header("Access-Control-Allow-Methods: DELETE");

        if($this->items->deleteUser($id)) {
            http_response_code(200);
            echo json_encode(array("message" => "User was deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete user."));
        }
    }
}