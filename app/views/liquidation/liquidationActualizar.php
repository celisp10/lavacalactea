<?php

if(!$_GET["id"]) {
    header("location:../index.php");
}

require '../../../vendor/autoload.php';

use App\Controllers\LiquidationController;
use App\Controllers\ProductController;
use App\Controllers\UserController;

$allProducts = ProductController::getAllProducts();
$allOperators = UserController::getAllUsers();

if($_GET) {
    $mg = isset($_GET["mg"]) ? $_GET["mg"] : NULL;
    $mr = isset($_GET["mr"]) ? $_GET["mr"] : NULL;
    $mo = isset($_GET["mo"]) ? $_GET["mo"] : NULL;
}

$id = $_GET["id"];

$liquidation = LiquidationController::getLiquidation($id);

if(!$liquidation) {
    header("location:../index.php");
}

if($_POST) {

    $id_product = $_POST["product"];
    $quantity_liters = $_POST["quantity_liters"];
    $farmer = $_POST["farmer"];
    $farm = $_POST["farm"];
    $id_operator = $_POST["operator"];

    try {
        $updateLiquidation = LiquidationController::updateLiquidation($id, $id_product, $quantity_liters, $farmer, $farm, $id_operator);
    } catch (Exception $e) {
        $mr = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar liquidación</title>

    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/liquidation.css">
    <link rel="stylesheet" href="../../../public/css/scripts.css">
</head>
<body>
    <header>
        <a class="btn r" href="liquidationVer.php">Atras</a>
    </header>

    <main class="liquidation_form">
        <h2 class="liquidation_title">Actulizar liquidación</h2>

        <div id="alerts">
            <?php if(isset($mg)) { ?>
                <p class="btn" style="background: green;"><?php echo $mg ?></p>
            <?php } ?>
            <?php if(isset($mr)) { ?>
                <p class="btn" style="background: red;"><?php echo $mr ?></p>
            <?php } ?>
            <?php if(isset($mo)) { ?>
                <p class="btn" style="background: orange;"><?php echo $mo ?></p>
            <?php } ?>
        </div>

        <form id="form" action="" method="POST">

        <div class="product-form">
                <select name="product" id="">
                    <option value="">Selecciona un producto</option>
                    <?php foreach($allProducts as $productInfo) { ?>
                        <option <?php if($liquidation["id_product"] == $productInfo["id"]) echo "selected" ?> value="<?php echo $productInfo["id"]; ?>"><?php echo $productInfo["name"]; ?></option>
                    <?php } ?>
                </select>
    
                <input name="quantity_liters" type="number" placeholder="Cantidad en litros" min="0" value="<?php echo $liquidation["quantity_liters"] ?>">
            </div>

            <input name="farmer" id="input" type="text" placeholder="Granjero" value="<?php echo $liquidation["farmer"] ?>">

            <input name="farm" type="text" placeholder="Granja" value="<?php echo $liquidation["farm"] ?>">

            <select name="operator" id="">
                <option value="">Selecciona el operador que le corresponde el registro</option>
                <?php foreach($allOperators as $operator) { ?>
                    <option <?php if($liquidation["id_operator"] == $operator["id"]) echo "selected" ?> value="<?php echo $operator["id"] ?>"><?php echo $operator["firs_name"]." ".$operator["firs_lastname"]; ?></option>
                <?php } ?>
            </select>

            <button id="open-modal" class="btn g" type="button">Actualizar registro</button>
            
            <div class="container-modal">
                <div class="modal">
                    <h2 class="title">¿Estas seguro de que deceas actualizar el registro?</h2>
                    <input class="btn g" type="submit" value="Actualizar registro">
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