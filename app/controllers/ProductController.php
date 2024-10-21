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
            return $product;
        } catch(Exception $e) {
            echo 'Error al obtener el producto: '.$e->getMessage();
        }
    }

    public static function updateProduct($id, $name, $price) {
        try {
            $updateProduct = ProductModel::updateProduct($id, $name, $price);
            header("location:productView.php?mo=Producto actualizado con exito");
        } catch (Exeption $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteProduct($id) {
        try {
            $delete = ProductModel::deleteProduct($id);
            header("location:productView.php?mr=Producto actualizado con exito");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function getAllProducts() {
        try {
            $products = ProductModel::getAllProducts();

            return $products;
        } catch(Exception $e) {
            echo 'Error al obtener los productos: '.$e->getMessage();
        }
    }
}