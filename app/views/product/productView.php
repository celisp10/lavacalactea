<?php

require '../../../vendor/autoload.php';
use App\Controllers\ProductController;

if($_GET) {
    $mg = isset($_GET["mg"]) ? $_GET["mg"] : NULL;
    $mr = isset($_GET["mr"]) ? $_GET["mr"] : NULL;
}

if($_POST) {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $price = isset($_POST["price"]) ? $_POST["price"] : "";

    try {
        $product = new ProductController($name, $price);
        $product->saveProduct();
    } catch (Exception $e) {
        echo 'Error: '.$e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/scripts.css">
</head>
<body>

    <header>
        <a class="btn r" href="../index.php">Atras</a>
    </header>

    <main>
        <h2 class="title">Registrar producto núevo</h2>

        <div id="alerts">
            <?php if(isset($mg)) { ?>
                <p class="btn" style="background: green;"><?php echo $mg ?></p>
            <?php } ?>
            <?php if(isset($mr)) { ?>
                <p class="btn" style="background: red;"><?php echo $mr ?></p>
            <?php } ?>
        </div>
        
        <form id="form" method="POST">
    
            <input name="name" type="text" placeholder="Nombre">
    
            <input name="price" type="number" placeholder="Precio" min="0">
    
            <button id="open-modal" class="btn g" type="button">Guardar producto</button>
            
            <div class="container-modal">
                <div class="modal">
                    <h2 class="title">¿Estas seguro de que deceas guardar el registro?</h2>
                    <input class="btn g" type="submit" value="Guardar producto">
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