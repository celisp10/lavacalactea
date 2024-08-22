<?php
require '../../../vendor/autoload.php';
use App\Controllers\LiquidationController;

$liquidations = LiquidationController::getAllLiquidations();

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
</head>
<body>
    <header>
        <a class="btn r" href="../index.php">Atras</a>
    </header>

    <main>
        <h2 class="liquidation_title">Registros de liquidación</h2>

        <section class="liquidation_registers">
            <!-- Start register -->
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
                    <a class="btn o" href="liquidationActualizar.php?id=<?php echo $liquidation["id"] ?>">Actualizar</a>
                    <button id="open-modal" class="btn r" type="button">Eliminar</button>
                    
                    <!-- Modal -->
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
                    <!-- Modal -->

                </div>
            </article>
            <?php } ?>
            <!-- End register -->
        </section>
    </main>
    <script src="../../../public/js/forms.js"></script>
</body>
</html>