<?php

namespace App\Controllers;

require '../../../vendor/autoload.php';
use App\Models\LiquidationModel;

class LiquidationController {

    public function __construct() {

    }

    public function saveLiquidation($id_product, $total_price, $quantity_liters, $farmer, $farm, $id_operator) {
        if(empty($id_product) or empty($total_price) or empty($quantity_liters) or empty($farmer) or empty($farm) or empty($id_operator)) {
            throw new Exception("Error en los datos recogidos"); 
        }
        try {
            $process = new LiquidationModel($id_product, $total_price, $quantity_liters, $farmer, $farm, $id_operator);
            $process->saveLiquidation();
            // Redirigir a la misma pagina con un mensaje por GET
            header("location:liquidationView.php?mg=Registro guardado exitosamete");
        } catch(Exception $e) {
            echo 'Error en el registro de liquidación: '.$e->getMessage();
        }
    }
}