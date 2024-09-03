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
    <title>La vaca lactea inicio</title>

    <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
    <header>
        <h2 class="log">La vaca lactea</h2>

        <nav>
            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bell" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                <path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
            </a>
            <a href="../user/profile.php?18"><img class="index__img-user" src="../../../public/img/<?php echo $user["image"]; ?>" alt="user-img"></a>
        </nav>
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

        <!-- <h2 class="title" style="margin: 50px 0; color: blue; font-size: 45px;">Bienvenido</h2> -->

        <h2 class="title">Opciones</h2>
        <section class="options">
            <!-- Start option -->
            <article class="option <?php if($_SESSION["position"] == "operator") echo $_SESSION["position"] ?>">
                <div class="header-option">
                    <h3>Registrar liquidación</h3>
                </div>
                <div class="main-option">
                    <p>Hacer el registro de liquidación de una compra de leche</p>
                    <a class="btn-option" href="../liquidation/liquidationView.php">Ir</a>
                </div>
            </article>
            <!-- End option -->
            <!-- Start option -->
            <!-- if($_SESSION["position"] == "operator")  -->
            <article class="option <?php echo $_SESSION["position"] ?>">
                <div class="header-option">
                    <h3>Ver liquidaciones</h3>
                </div>
                <div class="main-option">
                    <p>Ver, actualizar y eliminar registros de liquidación</p>
                    <a class="btn-option" href="../liquidation/liquidationVer.php">Ir</a>
                </div>
            </article>
            <!-- End option -->
            <!-- Start option -->
            <article class="option <?php if($_SESSION["position"] == "administrator") echo $_SESSION["position"] ?>">
                <div class="header-option">
                    <h3>Crear un núevo usuario</h3>
                </div>
                <div class="main-option">
                    <p>Crear y guardar un usuario núevo en el sistema</p>
                    <a class="btn-option" href="../user/userView.php">Ir</a>
                </div>
            </article>
            <!-- End option -->
            <!-- Start option -->
            <article class="option <?php if($_SESSION["position"] == "operator") echo $_SESSION["position"] ?>">
                <div class="header-option">
                    <h3>Guardar un núevo producto</h3>
                </div>
                <div class="main-option">
                    <p>Guardar los datos de un núevo producto en el sistema</p>
                    <a class="btn-option" href="../product/productView.php">Ir</a>
                </div>
            </article>
            <!-- End option -->
        </section>
    </main>

    <script src="../../../public/js/forms.js"></script>
</body>
</html>