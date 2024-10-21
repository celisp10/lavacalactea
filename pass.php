<?php

if($_POST) {
    $passEntered = $_POST["pass"];

    $passHash = password_hash($passEntered, PASSWORD_DEFAULT);

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hashear Password</title>

    <style>
        body {
            background: #0009;
        }
    </style>
</head>
<body>
    <h1>Hashear contraseña</h1>

    <form method="POST">

        <input name="pass" type="text" placeholder="Password hash">

        <input type="submit" value="Hashear">

    </form>

    <?php if (isset($passHash)) { ?>
        
        <h1 style="background: green;">Datos:</h1>

        <p>Datos ingresados: <?php echo $passEntered; ?></p>

        <p>Datos hasheados: <?php echo $passHash; ?></p>

    <?php } ?>

</body>
</html>