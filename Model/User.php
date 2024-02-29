<?php
class User {
    //Connection
    private $conn;
    //Table
    private $db_table = "users";
    //Columns
    public $id;
    public $username;
    public $password;
    public $email;
    public $role;
    public $photo;
    public $api_token; //null
    public $created_at; //null
    public $updated_at; //null
    //DB Connection
    public function __construct($db) {
        $this->conn = $db;
    }
    //Get All Records
    public function getUsers() {
        $sqlQuery = "SELECT id, username, password, email, role, photo, api_token, created_at, updated_at FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    //get single record
    public function getUser($id) {
        $sqlQuery = "SELECT id, username, password, email, role, photo, api_token, created_at, updated_at FROM " . $this->db_table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        //return $dataRow;
        $this->username = $dataRow['username'];
        $this->password = $dataRow['password'];
        $this->email = $dataRow['email'];
        $this->role = $dataRow['role'];
        $this->photo = $dataRow['photo'];
        $this->api_token = $dataRow['api_token'];
        $this->created_at = $dataRow['created_at'];
        $this->updated_at = $dataRow['updated_at'];
    }
    //get user by name
    public function getUserByUsername($username) {
        $sqlQuery = "SELECT id, username, password FROM users WHERE username = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($dataRow)) {
            return null;
        }
        return $dataRow;
    }
    //Create Record
    public function createUser() {
        $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        username = :username, 
                        password = :password, 
                        email = :email, 
                        role = :role,
                        api_token = :api_token";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_DEFAULT);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->api_token = bin2hex(random_bytes(32));
        // bind data
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":api_token", $this->api_token);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    //Update Record
    public function updateUser() {
        $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        username = :username, 
                        password = :password, 
                        email = :email, 
                        role = :role
                    WHERE 
                        id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_DEFAULT);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->id = htmlspecialchars(strip_tags($this->id));
        // bind data
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    //Update user api_token
    public function updateApiToken() {
        $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        api_token = :api_token
                    WHERE 
                        id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->api_token = bin2hex(random_bytes(32));
        $this->id = htmlspecialchars(strip_tags($this->id));
        // bind data
        $stmt->bindParam(":api_token", $this->api_token);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    //Delete Record
    public function deleteUser($id) {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}