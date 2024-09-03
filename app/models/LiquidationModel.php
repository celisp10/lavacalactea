<?php

namespace App\Models;

require '../../../vendor/autoload.php';
use App\Configs\Database;

date_default_timezone_set("America/Bogota");

class LiquidationModel {
    private $id_product;
    private $total_price;
    private $quantity_liters;
    private $farmer;
    private $farm;
    private $date_created;
    private $id_operator;
    private $pdo;
    private static $dbInstance;

    public function __construct($id_product, $total_price, $quantity_liters, $farmer, $farm, $id_operator) {
        $this->id_product = $id_product;
        $this->total_price = $total_price;
        $this->quantity_liters = $quantity_liters;
        $this->farmer = $farmer;
        $this->farm = $farm;
        $this->date_created = date("Y/m/d");
        $this->id_operator = $id_operator;
        $database = new Database;
        $this->pdo = $database->getPDO();
    }

    public function saveLiquidation() {
        $stmt = $this->pdo->prepare("INSERT INTO liquidations (id_product, total_price, quantity_liters, farmer, farm, date_created, id_operator) 
        VALUES (:id_product, :total_price, :quantity_liters, :farmer, :farm, :date_created, :id_operator)");

        $stmt->bindParam(":id_product", $this->id_product);
        $stmt->bindParam(":total_price", $this->total_price);
        $stmt->bindParam(":quantity_liters", $this->quantity_liters);
        $stmt->bindParam(":farmer", $this->farmer);
        $stmt->bindParam(":farm", $this->farm);
        $stmt->bindParam(":date_created", $this->date_created);
        $stmt->bindParam(":id_operator", $this->id_operator);
        $stmt->execute();
    }

    public static function getAllLiquidations() {
        self::$dbInstance = new Database;
        $pdo = self::$dbInstance->getPDO();

        $stmt = $pdo->prepare("SELECT l.*, p.name AS product_name, u.firs_name AS operator_first_name, u.firs_lastname AS operator_first_lastname
        FROM liquidations l JOIN products p ON l.id_product = p.id JOIN users u ON l.id_operator = u.id");
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }

    public static function getLiquidation($id) {
        self::$dbInstance = new Database;
        $pdo = self::$dbInstance->getPDO();

        $stmt = $pdo->prepare("SELECT * FROM liquidations WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $resultado;
    }

    public static function updateLiquidation($id, $id_product, $total_price, $quantity_liters, $farmer, $farm, $id_operator) {
        self::$dbInstance = new Database;
        $pdo = self::$dbInstance->getPDO();

        $date_update = date("Y/m/d");

        $stmt = $pdo->prepare("UPDATE liquidations SET id_product = $id_product, total_price = $total_price, quantity_liters = $quantity_liters, farmer = '$farmer', farm = '$farm', date_update = '$date_update' WHERE id = $id");
        $stmt->execute();
    }

    public static function deleteLiquidation($id) {
        self::$dbInstance = new Database;
        $pdo = self::$dbInstance->getPDO();

        $stmt = $pdo->prepare("DELETE FROM liquidations WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if(!$stmt) {
            throw new \Exception("Error al intentar eliminar el registro");
        }
    }
}