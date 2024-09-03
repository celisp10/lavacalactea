<?php

include '../../../configs/session.php';

$id = $_GET["id"];

if(!$id) {
    header("location:liquidationVer.php");
}

require '../../../vendor/autoload.php';
use App\Controllers\LiquidationController;

if($_GET) {
    $mg = isset($_GET["mg"]) ? $_GET["mg"] : NULL;
    $mr = isset($_GET["mr"]) ? $_GET["mr"] : NULL;
}

if($_POST) {
    try {
        $liquidations = LiquidationController::deleteLiquidation($id);
    } catch (\Exception $e) {
        $mr = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete liquidation</title>

    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
</head>
<body class="delete-liquidation">

    <div id="alerts">
        <?php if(isset($mg)) { ?>
            <p class="btn" style="background: green;"><?php echo $mg ?></p>
        <?php } ?>
        <?php if(isset($mr)) { ?>
            <p class="btn" style="background: red;"><?php echo $mr ?></p>
        <?php } ?>
    </div>

    <h2 class="title">¿Estás seguro de borrar el registro?</h2>

    <form style="width: 400px;" method="POST">

        <input name="id_liquidation" type="hidden" value="<?php echo $id; ?>">

        <input class="btn r" type="submit" value="Borrar">

        <a class="btn o" href="liquidationVer.php">Cancelar</a>
    </form>


</body>
</html>