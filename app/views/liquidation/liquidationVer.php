<?php

include '../../../configs/session.php';

require '../../../vendor/autoload.php';
use App\Controllers\LiquidationController;

try {
    $liquidations = LiquidationController::getAllLiquidations();
} catch (\Exception $e) {
    $mg = $e->getMessage();
}

if($_GET) {
    $mg = isset($_GET["mg"]) ? $_GET["mg"] : NULL;
    $mr = isset($_GET["mr"]) ? $_GET["mr"] : NULL;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de liquidación</title>

    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/liquidation.css">
    <link rel="stylesheet" href="../../../public/css/scripts.css">
    <link rel="stylesheet" href="../../../public/css/modalRegisters.css">
</head>
<body>
    <header>
        <a class="btn r" href="../start/index.php">Atras</a>
    </header>

    <main>

        <div id="alerts">
            <?php if(isset($mg)) { ?>
                <p class="btn" style="background: green;"><?php echo $mg ?></p>
            <?php } ?>
            <?php if(isset($mr)) { ?>
                <p class="btn" style="background: red;"><?php echo $mr ?></p>
            <?php } ?>
        </div>

        <h2 class="liquidation_title">Registros de liquidación</h2>

        <section class="liquidation_registers">
            <!-- Start register -->
            <?php if(!empty($liquidations)) { ?>
                <?php foreach($liquidations as $liquidation) { ?>
                <article class="liquidation_register">
                    <h3>Id: <?php echo $liquidation["id"] ?></h3>
                    <p>Producto: <?php echo $liquidation["product_name"] ?></p>
                    <p>Precio total: <?php $price = number_format($liquidation["total_price"], 0, ',', '.'); echo $price ?> pesos</p>
                    <p>Cantidad en litros: <?php echo $liquidation["quantity_liters"] ?></p>
                    <p>Granjero: <?php echo $liquidation["farmer"] ?></p>
                    <p>Granja: <?php echo $liquidation["farm"] ?></p>
                    <p>Fecha de creación: <?php echo $liquidation["date_created"] ?></p>
                    <p>Ultima actualización: <?php echo isset($liquidation["date_update"]) ? $liquidation["date_update"] : "Ninguna"; ?></p>
                    <p>Operador: <?php echo $liquidation["operator_first_name"]." ".$liquidation["operator_first_lastname"] ?></p>
                    <div class="liquidation_options">
                        <a class="btn o <?php if($_SESSION["position"] == "operator") echo $_SESSION["position"] ?>" href="liquidationActualizar.php?id=<?php echo $liquidation["id"] ?>">Actualizar</a>

                        <a class="btn r <?php if($_SESSION["position"] == "operator") echo $_SESSION["position"] ?>" href="deleteLiquidation.php?id=<?php echo $liquidation["id"] ?>">Eliminar</a>

                    </div>
                </article>
                <?php } ?>
            <?php } else { ?>
                <p class="title"><?php echo "No se encontraron resultados" ?></p>
            <?php } ?>
            <!-- End register -->
        </section>
    </main>
    <script src="../../../public/js/forms.js"></script>
</body>
</html>