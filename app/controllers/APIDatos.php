<?php
// header("location:../views/start/index.php");
include '../../configs/session.php';

require '../../vendor/autoload.php';
use App\Configs\Database;

$id_user = $_SESSION["id"];
$position = $_SESSION["position"];

date_default_timezone_set("America/Bogota");

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *"); // Define permisos a externos para ingresar a la API.

// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); Define tipos de comunicación con la base de datos.
// header("Access-Control-Allow-Headers: Content-Type, Authorization"); No entendí bien.

try {

    // Get PDO width class Database
    $database = new Database();
    $pdo = $database->getPDO();
    
    //Five liquidations most expensive
    $stmt = $pdo->prepare("SELECT * FROM liquidations ORDER BY total_price DESC LIMIT 5");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Quantity liters (All and today)
    $date_today = date("Y/m/d");

    if($position == "operator") {
        $stmt2 = $pdo->prepare("SELECT COUNT(*) as liq FROM liquidations WHERE id_operator = :id_user 
        UNION 
        SELECT COUNT(*) FROM liquidations WHERE date_created = :date_today ");
        $stmt2->bindParam(":date_today", $date_today);
        $stmt2->bindParam(":id_user", $id_user);
    } else if($position == "administrator") {
        $stmt2 = $pdo->prepare("SELECT COUNT(*) as liq FROM liquidations
        UNION 
        SELECT COUNT(*) FROM liquidations WHERE date_created = :date_today ");
        $stmt2->bindParam(":date_today", $date_today);
    }

    $stmt2->execute();
    $resultado2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $allLiquidations = isset($resultado2[0]["liq"]) ? $resultado2[0]["liq"] : NULL;
    $liquidationsToday = isset($resultado2[1]["liq"]) ? $resultado2[1]["liq"] : NULL;

    $stmt3 = $pdo->prepare("SELECT id_operator, COUNT(*) as total_liquidations FROM liquidations GROUP BY id_operator");
    $stmt3->execute();
    $resultado3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["liquidations" => $resultado, "allLiq" => $allLiquidations, "liqToday" => $liquidationsToday, "liqPerUser" => $resultado3]);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode([
        "Error" => "Error al obtener los datos",
        "message" => $e->getMessage()
    ]);
}

// print_r(["liquidations" => $resultado, "allLiq" => $allLiquidations, "liqToday" => $liquidationsToday, "liqPerUser" => $resultado3]);

