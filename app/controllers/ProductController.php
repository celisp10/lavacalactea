<?php

namespace App\Controllers;

require '../../../vendor/autoload.php';
use App\Models\ProductModel;

class ProductController {
    private $name;
    private $price;

    public function __construct($name, $price) {
        if(empty($name) or empty($price)) {
            throw new \Exception("Los datos no pueden estar vacios");
        } else {
            $this->name = $name;
            $this->price = $price;
        }
    }

    public function saveProduct() {
        try {
            $process = new ProductModel($this->name, $this->price);
            $process->saveProduct();
            if(!$process) {
                throw new \Exception("Error en el guardado del producto");
            }
            header("location:productView.php?mg=Producto guardado con exito");
        } catch(Exception $e) {
            echo 'Error en el proceso de guardado: '.$e->getMessage();
        }
    }

    public static function getProduct($id) {
        try {
            $product = ProductModel::getProduct($id);

            if(!$product) {
                throw new \Exception("No se encontró ningun producto o hubo un error");
            }

            return $product;
        } catch(Exception $e) {
            echo 'Error al obtener el producto: '.$e->getMessage();
        }
    }

    public static function getAllProducts() {
        try {
            $products = ProductModel::getAllProducts();

            if(!$products) {
                throw new \Exception("No se encuentran productos registrados o hubo un error");
            }

            return $products;
        } catch(Exception $e) {
            echo 'Error al obtener los productos: '.$e->getMessage();
        }
    }
}