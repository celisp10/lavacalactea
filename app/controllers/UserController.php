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
    private $image;
    private $tmpName;
    private $password;
    private $pdo;
    private static $userImageDefault = 'sin-foto.jpg';

    public function __construct($firstName, $secondName, $firstLastName, $secondLastName, $cc, $age, $email, $telephone, $position, $image, $password) {
        if(empty($firstName) or empty($firstLastName)  or empty($cc) or empty($age) or empty($email) or empty($telephone) or empty($position) or empty($password)) {
            throw new \Exception("Todos los campos deben estar llenos excepto seg apellido, seg nombre y la foto");
        }

        if(!$image) {
            $this->image = self::$userImageDefault;
        } else {
            $this->tmpName = $image["tmp_name"];
            $time = time();
            $nameImage = $time.$image["name"];
            $this->image = $nameImage;
            $saveImage = true;
        }

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

            if($saveImage) {
                move_uploaded_file($this->tmpName, "../../public/img/".$this->image);
            }

            header("location:userView.php?mg=Usuario agregado correctamente");
        } catch(\Exception $e) {
            echo "Error: ".$e->getMessage();
        }
    }
}
