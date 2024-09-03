<?php

namespace App\Controllers;

require '../../../vendor/autoload.php';
use App\Models\UserModel;

class UserController {
    private $firstName;
    private $secondName = NULL;
    private $firstLastName;
    private $secondLastName = NULL;
    private $cc;
    private $age;
    private $email;
    private $telephone;
    private $position;
    private $image = NULL;
    private $tmpName;
    private $password;
    private $pdo;
    private $saveImage;
    private static $userImageDefault = 'image-default.jpg';

    public function __construct($firstName, $secondName, $firstLastName, $secondLastName, $cc, $age, $email, $telephone, $position, $image, $password) {
        if(empty($firstName) or empty($firstLastName)  or empty($cc) or empty($age) or empty($email) or empty($telephone) or empty($position) or empty($password)) {
            throw new \Exception("Todos los campos deben estar llenos excepto seg apellido, seg nombre y la foto");
        }

        if(empty($image) or $image["error"] > 0) {
            $this->image = self::$userImageDefault;
            $this->saveImage = false;
        } else {
            $this->tmpName = $image["tmp_name"];
            $time = time();
            $nameImage = $time.$image["name"];
            $this->image = $nameImage;
            $this->saveImage = true;
        }

        // print_r($this->image);

        $this->firstName = $firstName;
        $this->secondName = $secondName;
        $this->firstLastName = $firstLastName;
        $this->secondLastName = $secondLastName;
        $this->cc = $cc;
        $this->age = $age;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->position = $position;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function saveUser() {
        try {
            $newUser = new UserModel($this->firstName, $this->secondName, $this->firstLastName, $this->secondLastName, $this->cc, $this->age, $this->email, $this->telephone, $this->position, $this->image, $this->password);
            $newUser->saveUser();

            if($this->saveImage) {
                $targetDir = __DIR__."../../../public/img/";
                move_uploaded_file($this->tmpName, $targetDir.$this->image);
            }

            header("location:userView.php?mg=Usuario agregado correctamente");
        } catch(\Exception $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public static function getAllOperators() {
        $users = UserModel::getAllOperators();
        return $users;
    }

    public static function getUser($id) {
        $user = UserModel::getUser($id);
        if(!$user) {
            throw new \Exception("Usuario no encontrado u ocurrió un error");
        }
        return $user;
    }

    public static function login($email, $password) {
        
        $user = UserModel::login($email);
        if(!$user) {
            throw new \Exception("El correo no se encuentra registrado");
        }

        $verifyPassword = password_verify($password, $user["password"]);

        if(!$verifyPassword) {
            throw new \Exception("La contraseña es incorrecta");
        }

        session_start();

        $_SESSION["id"] = $user["id"];
        
        $_SESSION["position"] = $user["position"];
        
        header("location:../start/index.php");
    }
}
