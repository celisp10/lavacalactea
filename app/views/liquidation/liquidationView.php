<?php

require '../../../vendor/autoload.php';

use App\Controllers\LiquidationController;
use App\Controllers\ProductController;

$allProducts = ProductController::getAllProducts();

if($_GET) {
    $mg = isset($_GET["mg"]) ? $_GET["mg"] : NULL;
    $mr = isset($_GET["mr"]) ? $_GET["mr"] : NULL;
}

if($_POST) {
    
    $id_product = $_POST["product"];
    $quantity_liters = $_POST["quantity_liters"];
    $farmer = $_POST["farmer"];
    $farm = $_POST["farm"];
    $id_operator = $_POST["operator"];

    try {
        $productPrice = ProductController::getProduct($id_product);
        print_r($productPrice);
    } catch(Exception $e) {
        $mr = $e->getMessage();
    }

    $total_price = $productPrice["price"] * $quantity_liters;
    
    try {
        $liquidation = new LiquidationController();
        $liquidation->saveLiquidation($id_product, $total_price, $quantity_liters, $farmer, $farm, $id_operator);
    } catch(Exception $e) {
        $mr = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de liquidación</title>

    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/liquidation.css">
    <link rel="stylesheet" href="../../../public/css/scripts.css">
</head>
<body>
    <header>
        <a class="btn r" href="../index.php">Atras</a>
    </header>

    <main class="liquidation_form">
        <h2 class="liquidation_title">Registrar liquidación</h2>

        <div id="alerts">
            <?php if(isset($mg)) { ?>
                <p class="btn" style="background: green;"><?php echo $mg ?></p>
            <?php } ?>
            <?php if(isset($mr)) { ?>
                <p class="btn" style="background: red;"><?php echo $mr ?></p>
            <?php } ?>
        </div>

        <form id="form" action="" method="POST">

            <div class="product-form">
                <select name="product" id="">
                    <option value="">Selecciona un producto</option>
                    <?php foreach($allProducts as $productInfo) { ?>
                        <option value="<?php echo $productInfo["id"]; ?>"><?php echo $productInfo["name"]; ?></option>
                    <?php } ?>
                </select>
    
                <input name="quantity_liters" type="number" placeholder="Cantidad en litros" min="0">
            </div>

            <input name="farmer" id="input" type="text" placeholder="Granjero">

            <input name="farm" type="text" placeholder="Granja">

            <select name="operator" id="">
                <option value="">Selecciona el operador que le corresponde el registro</option>
                <option value="1">Esteban celis</option>
            </select>

            <button id="open-modal" class="btn g" type="button">Guardar registro</button>
            
            <div class="container-modal">
                <div class="modal">
                    <h2 class="title">¿Estas seguro de que deceas guardar el registro?</h2>
                    <input class="btn g" type="submit" value="Guardar registro">
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x close-modal" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </div>

        </form>
    </main>

    <script src="../../../public/js/forms.js"></script>
</body>
</html>