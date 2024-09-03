<?php
include '../../../configs/session.php';

include '../../../vendor/autoload.php';
use App\Controllers\UserController;

$userId = $_SESSION["id"];

try {
    $user = UserController::getUser($userId);
} catch (\Exception $e) {
    $mr = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de liquidación</title>

    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/profile.css">
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

        <section class="data-user">
            <img class="profile_img-user" src="../../../public/img/<?php echo $user["image"]; ?>" alt="img-user">
            <p><?php echo $user["firs_name"]." ".$user["second_name"]." ".$user["firs_lastname"] ; ?></p>
        </section>

        <section class="info-user">
            <p>Correo: <?php echo $user["email"]; ?></p>
            <p>Hora de ingreso: Pronto...</p>
            <p>Cargo: <?php echo $user["position"]; ?></p>
            <a class="btn r" href="../../../configs/closeSession.php">Cerrar sesión</a>
        </section>
    </main>
    
</body>
</html>