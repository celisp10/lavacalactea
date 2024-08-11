<?php

namespace App\Models;

require '../../../vendor/autoload.php';
use App\Configs\Database;

date_default_timezone_set("America/Bogota");

class UserModel {
    private $firsName;
    private $secondName;
    private $firsLastName;
    private $secondLastName;
    private $cc;
    private $age;
    private $email;
    private $telephone;
    private $position;
    private $image;
    private $password;
    private $date_created;
    private $pdo;

    public function __construct($firsName, $secondName, $firsLastName, $secondLastName, $cc, $age, $email, $telephone, $position, $image, $password) {
        $this->firsName = $firsName;
        $this->secondName = $secondName;
        $this->firsLastName = $firsLastName;
        $this->secondLastName = $secondLastName;
        $this->cc = $cc;
        $this->age = $age;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->position = $position;
        $this->image = $image;
        $this->password = $password;
        $this->date_created = date("Y/m/d");
        $database = new Database;
        $this->pdo = $database->getPDO();
    }

    public function saveUser() {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (firs_name, second_name, firs_lastname, second_lastname, cc, age, email, telephone, position, image, password, date_created) 
            VALUES (:firsname, :secondname, :firslastname, :secondlastname, :cc, :age, :email, :telephone, :position, :image, :password, :date_created)");
    
            $stmt->bindParam(":firsname", $this->firsName);
            $stmt->bindParam(":secondname", $this->secondName);
            $stmt->bindParam(":firslastname", $this->firsLastName);
            $stmt->bindParam(":secondlastname", $this->secondLastName);
            $stmt->bindParam(":cc", $this->cc);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":telephone", $this->telephone);
            $stmt->bindParam(":position", $this->position);
            $stmt->bindParam(":image", $this->image);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":date_created", $this->date_created);
            $stmt->execute();
            
            if(!$stmt) {
                throw new \Exception("Error al intentar guardar el usuario");
            }
        } catch(\Exception $e) {
            echo "Error: ".$e->getMessage();
        }
    }
}