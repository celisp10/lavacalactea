<?php

namespace App\Controllers;

require '../../../vendor/autoload.php';
use App\Models\LiquidationModel;
use App\Controllers\ProductController;

class LiquidationController {

    public function __construct() {

    }

    public static function totalPrice($id_product, $quantity_liters) {
        $productPrice = ProductController::getProduct($id_product);
        $total_price = $productPrice["price"] * $quantity_liters;
        return $total_price;
    }

    public function saveLiquidation($id_product, $quantity_liters, $farmer, $farm, $id_operator) {
        if(empty($id_product) or empty($quantity_liters) or empty($farmer) or empty($farm) or empty($id_operator)) {
            throw new \Exception("Ningún campo puede estar vacio"); 
        }

        $total_price = LiquidationController::totalPrice($id_product, $quantity_liters);

        try {
            $process = new LiquidationModel($id_product, $total_price, $quantity_liters, $farmer, $farm, $id_operator);
            $process->saveLiquidation();
            // Redirigir a la misma pagina con un mensaje por GET
            header("location:liquidationView.php?mg=Registro guardado exitosamete");
        } catch(Exception $e) {
            echo 'Error en el registro de liquidación: '.$e->getMessage();
        }
    }

    public static function getAllLiquidations() {
        try {
            $liquidations = LiquidationModel::getAllLiquidations();
            if(empty($liquidations)) {
                throw new \Exception("No se encontraron resultados o hubo un error");
            }
            return $liquidations;
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function getLiquidation($id) {
        try {
            $liquidations = LiquidationModel::getLiquidation($id);
            if(empty($liquidations)) {
                throw new \Exception("No se encontraron resultados o hubo un error");
            }
            return $liquidations;
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function updateLiquidation($id, $id_product, $quantity_liters, $farmer, $farm, $id_operator) {
        if(empty($id_product) or empty($quantity_liters) or empty($farmer) or empty($farm) or empty($id_operator)) {
            throw new \Exception("Ningún campo puede estar vacio"); 
        }
        
        try {
            $total_price = LiquidationController::totalPrice($id_product, $quantity_liters);

            $process = LiquidationModel::updateLiquidation($id, $id_product, $total_price, $quantity_liters, $farmer, $farm, $id_operator);

            header("location:liquidationVer.php?mg=Registro actualizado exitosamete");
        } catch (\Exception $e) {
            echo "No se pudo actualizar el registro: ".$e->getMessage();
        }

        
    }

}