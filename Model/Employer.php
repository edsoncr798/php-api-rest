<?php

class Employer {
    //Connection
    private $conn;
    //Table
    private $db_table = "employers";
    //Columns
    public $id;
    public $name;
    public $email;
    public $age;
    public $designation;
    public $created; //null

    //DB Connection
    public function __construct($db) {
        $this->conn = $db;
    }
    //Get All Records
    public function getEmployers() {
        $sqlQuery = "SELECT id, name, email, age, designation, created FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    //get single record
    public function getEmployer($id) {
        $sqlQuery = "SELECT id, name, email, age, designation, created FROM " . $this->db_table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        //return $dataRow;
        $this->name = $dataRow['name'];
        $this->email = $dataRow['email'];
        $this->age = $dataRow['age'];
        $this->designation = $dataRow['designation'];
        $this->created = $dataRow['created'];
    }
    //Create Record
    public function createEmployer() {
        $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name,
                        email = :email,
                        age = :age,
                        designation = :designation";
        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->designation=htmlspecialchars(strip_tags($this->designation));
        // bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":designation", $this->designation);
        if($stmt->execute()) {
           return true;
        }
        return false;
    }

    //Update Record

    public function updateEmployer() {
        $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name,
                        email = :email,
                        age = :age,
                        designation = :designation
                    WHERE
                        id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->designation=htmlspecialchars(strip_tags($this->designation));
        $this->id=htmlspecialchars(strip_tags($this->id));
        // bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":designation", $this->designation);
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute()) {
           return true;
        }
        return false;
    }
    //Delete Record
    function deleteEmployer($id) {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id=htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}