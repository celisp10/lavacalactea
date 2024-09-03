<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("location: /lavacalactea/app/views/user/login.php");
}

?>
