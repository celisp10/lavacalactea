<?php 
include '../../../configs/session.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagramas || Estadisticas</title>
    
    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/diagrams.css">
</head>
<body>
    
    <header>
        <a class="btn r" href="../start/index.php">Atras</a>
    </header>

    <main>
        <h2 class="title">Estadisticas</h2>

        <div id="alerts">
            
        </div>

        <section class="container_diagrams">
            <article>
                <h2 class="title">Liquidaciones más caras</h2>
                <canvas id="myChart"></canvas>
            </article>
            <article>
                <?php if($_SESSION["position"] == "administrator") echo "<h2 class='title'>Historial de liq (todos los usuarios)</h2>" ?>
                <?php if($_SESSION["position"] == "operator") echo "<h2 class='title'>Historial de liq (tu)</h2>" ?>
                <canvas id="myChart2"></canvas>
            </article>
            <article>
                <h2 class="title">LIquidaciones por usuario</h2>
                <canvas id="myChart3"></canvas>
            </article>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        fetch("http://localhost/lavacalactea/app/controllers/APIDatos.php")
            .then(res => res.json())
            .then(resultado => {

                const jsonPrice = []
                const jsonId = []
                resultado.liquidations.forEach(liquidation => {
                    jsonPrice.push(liquidation.total_price)
                    jsonId.push("Liq ID: " + liquidation.id)
                })

                const ctx = document.getElementById("myChart").getContext("2d")
                
                const myChart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: jsonId,
                        datasets: [{
                            label: "Liquidaciones más caras",
                            data: jsonPrice,
                            backgroundColor: "#181925",
                            borderColor: "#fff",
                            borderWidth: 1
                        }]
                    }
                })

                const ctx2 = document.getElementById("myChart2").getContext("2d")
                const allLiq = resultado.allLiq
                const liqToday = resultado.liqToday

                const myChart2 = new Chart(ctx2, { 
                    type: "polarArea",
                    data: {
                        labels: ["Todas las liquidaciones", "Liquidaciones hoy"],
                        datasets: [{
                            label: "Historial liquidaciones",
                            data: [allLiq, liqToday],
                            backgroundColor: "#181925",
                            borderColor: "#fff",
                            borderWidth: 1
                            }]
                        },
                        options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                            }
                        }
                })

                const ctx3 = document.getElementById("myChart3").getContext("2d")

                const jsonIdUser = []
                const jsonLiqUser = []

                resultado.liqPerUser.forEach(liquidation => {
                    jsonIdUser.push("User ID: " + liquidation.id_operator)
                    jsonLiqUser.push(liquidation.total_liquidations)
                })

                const myChart3 = new Chart(ctx3, { 
                    type: "line",
                    data: {
                        labels: jsonIdUser,
                        datasets: [{
                            label: "LIquidaciones por usuario",
                            data: jsonLiqUser,
                            backgroundColor: "#181925",
                            borderColor: "#fff",
                            borderWidth: 1
                            }]
                        },
                        options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                            }
                        }
                    })
                }

            )
            .catch(error => console.error('Error fetching data:', error));
            
    </script>
</body>
</html>