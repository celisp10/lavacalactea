<?php

namespace App\Models;

require '../../../vendor/autoload.php';
use App\Configs\Database;

date_default_timezone_set("America/Bogota");

class ProductModel {
    private $name;
    private $price;
    private $date_created;
    private $pdo;
    private static $dbInstance;
    
    public function __construct($name = NULL, $price = NULL) {
        $this->name = $name;
        $this->price = $price;
        $this->date_created = date("Y/m/d");
        $database = new Database;
        $this->pdo = $database->getPDO();
    }
    
    public function saveProduct() {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, price, date_created) VALUES (:name, :price, :date_created)");
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":date_created", $this->date_created);
        $stmt->execute();
    }
    
    public static function getProduct($id) {
        self::$dbInstance = new Database;
        $pdo = self::$dbInstance->getPDO();
        
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultado;
    }
    
    public static function getAllProducts() {
        self::$dbInstance = new Database;
        $pdo = self::$dbInstance->getPDO();
        
        $stmt = $pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultado;
    }
}