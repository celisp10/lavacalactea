<?php

require '../../../vendor/autoload.php';
use App\Controllers\UserController;

if($_GET) {
    $mg = isset($_GET["mg"]) ? $_GET["mg"] : NULL;
    $mr = isset($_GET["mr"]) ? $_GET["mr"] : NULL;
}

if($_POST) {
    
    // print_r($_POST);
    
    $firsName = $_POST["firsName"];
    $secondName = $_POST["secondName"];
    $firsLastName = $_POST["firsLastname"];
    $secondLastName = $_POST["secondLastname"];
    $cc = $_POST["cc"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $position = $_POST["position"];
    $image = isset($_FILES["image"]) ? $_FILES["image"] : NULL;
    $password = $_POST["password"];
    
    try {
        $newUser = new UserController($firsName, $secondName, $firsLastName, $secondLastName, $cc, $age, $email, $telephone, $position, $image, $password);
        $newUser->saveUser();
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
    <title>Núevo usuario</title>

    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/scripts.css">
</head>
<body>
    <header>
        <a class="btn r" href="../index.php">Atras</a>
    </header>

    <main>
        <h2 class="title">Crear núevo usuario</h2>

        <div id="alerts">
            <?php if(isset($mg)) { ?>
                <p class="btn" style="background: green;"><?php echo $mg ?></p>
            <?php } ?>
            <?php if(isset($mr)) { ?>
                <p class="btn" style="background: red;"><?php echo $mr ?></p>
            <?php } ?>
        </div>
        
        <form id="form" method="POST" enctype="multipart/form-data">
            <p style="font-size: 15px;">Las imagenes junto con los inputs que contengas (-) no son obligatorios.</p>
            
            <input name="firsName" type="text" placeholder="Primer nombre">
            <input name="secondName" class="no-use" type="text" placeholder="Segundo nombre (-)">

            <input name="firsLastname" type="text" placeholder="Primer apellido">
            <input name="secondLastname" class="no-use" type="text" placeholder="Segundo apellido (-)">

            <input name="cc" type="text" placeholder="Cedula">
            
            <input name="age" type="text" placeholder="Edad">

            <input name="email" type="text" placeholder="Correo electronico">

            <input name="telephone" type="text" placeholder="Número celular">
            
            <select name="position">
                <option value="">Seleccione cargo</option>
                <option value="operator">Operario</option>
                <option value="adminitrator">Administrador</option>
            </select>

            <input name="image" class="no-use" type="file" accept="image/jpeg, image/png, image/gif">
            
            <input name="password" type="text" placeholder="Contraseña">

            <button id="open-modal" class="btn g" type="button">Guardar registro</button>
            
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