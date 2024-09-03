<?php

require '../../../vendor/autoload.php';
use App\Controllers\UserController;

if($_POST) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        $user = UserController::login($email, $password);
        print_r($user);
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
    <title>Log in</title>

    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/scripts.css">
</head>
<body>
    <main class="container_log-in">

        <div id="alerts">
            <?php if(isset($mg)) { ?>
                <p class="btn" style="background: green;"><?php echo $mg ?></p>
            <?php } ?>
            <?php if(isset($mr)) { ?>
                <p class="btn" style="background: red;"><?php echo $mr ?></p>
            <?php } ?>
        </div>

        <h2 class="title">Inicio de sesión</h2>
        <form id="form" method="POST">
            <input name="email" type="email" placeholder="Correo">

            <input name="password" type="password" placeholder="Contraseña">

            <input class="btn g" type="submit" value="Iniciar sesión">
        </form>
    </main>

    <script src="../../../public/js/forms.js"></script>
</body>
</html>