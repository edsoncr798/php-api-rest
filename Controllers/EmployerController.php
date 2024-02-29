<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once $_SERVER['DOCUMENT_ROOT'] . '/php-api-rest/Config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php-api-rest/Model/Employer.php';

class EmployerController {
    private $database;
    private $db;
    private $items;

    public function __construct(){
        $this->database = new Database();
        $this->db = $this->database->getConnection();
        $this->items = new Employer($this->db);
    }

    //Read all employers
    public function read() {
        header("Access-Control-Allow-Methods: GET");

        $stmt = $this->items->getEmployers();
        $num = $stmt->rowCount();

        if($num > 0) {
            $employers_arr = array();
            $employers_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $employer_item = array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                    "age" => $age,
                    "designation" => $designation,
                    "created" => $created,
                );
                array_push($employers_arr["records"], $employer_item);
            }
            http_response_code(200);
            echo json_encode($employers_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No employers found."));
        }
    }
    //Read single employer
    public function readSingle($id) {
        header("Access-Control-Allow-Methods: GET");

        $this->items->getEmployer($id);
        $employer_item = array(
            "id" => $this->items->id,
            "name" => $this->items->name,
            "email" => $this->items->email,
            "age" => $this->items->age,
            "designation" => $this->items->designation,
            "created" => $this->items->created,
        );
        http_response_code(200);
        echo json_encode($employer_item);
    }
    //Create employer
    public function create() {
        header("Access-Control-Allow-Methods: POST");

        $json = file_get_contents("php://input");
        $data = json_decode($json);

        if(!empty($data->name) && !empty($data->email) && !empty($data
        ->age) && !empty($data->designation)) {
            $this->items->name = $data->name;
            $this->items->email = $data->email;
            $this->items->age = $data->age;
            $this->items->designation = $data->designation;
            if($this->items->createEmployer()) {
                http_response_code(201);
                echo json_encode(array("message" => "Employer was created."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create employer."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create employer. Data is incomplete."));
        }
    }
    //Update employer
    public function update() {
        header("Access-Control-Allow-Methods: PUT");

        $data = json_decode(file_get_contents("php://input"));

        // reference id send by body
        $this->items->id = $data->id;

        //employer values
        $this->items->name = $data->name;
        $this->items->email = $data->email;
        $this->items->age = $data->age;
        $this->items->designation = $data->designation;

        if($this->items->updateEmployer()) {
            http_response_code(200);
            echo json_encode(array("message" => "Employer was updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update employer."));
        }

    }
    //Delete employer
    public function delete($id) {
        header("Access-Control-Allow-Methods: DELETE");

        if($this->items->deleteEmployer($id)) {
            http_response_code(200);
            echo json_encode(array("message" => "Employer was deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete employer."));
        }
    }
}