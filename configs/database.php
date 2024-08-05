<?php

class connectionDB{
    private $server = 'localhost';
    private $dbname = 'la_vaca_lactea_db'; 
    private $user = 'root';
    private $dbpassword = '';
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=$this->server;dbname=$this->dbname", $this->user, $this->dbpassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch(PDOException $e) {
            echo 'Error en la conexión a la base de datos: '.$e->getMessage();
        }
    }
}