<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Lateral con Acordeón hacia la Derecha</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 280px;
            background-color: #f8f9fa;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .sidebar a.active {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .sidebar .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .sidebar .user-info img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            text-align: left;
            border: none;
            outline: none;
            transition: 0.4s;
            margin-bottom: 10px;
            position: relative;
        }

        .active, .accordion:hover {
            background-color: #ccc;
        }

        .panel {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            width: 200px;
            background-color: white;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
            border-radius: 5px;
        }

        .panel a {
            display: block;
            padding: 8px 10px;
            text-decoration: none;
            color: #444;
            border-radius: 3px;
        }

        .panel a:hover {
            background-color: #f1f1f1;
        }

        .main-content {
            margin-left: 300px;
            padding: 20px;
            width: calc(100% - 300px);
        }

        .main-content h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="user-info">
            <img src="" width="40" height="40">
            <strong>mdo</strong>
        </div>
        <a href="#" class="active">Principal</a>
        <button class="accordion">Datos de Empresa</button>
        <div class="panel">
            <?php
            require("conexion.php");

            // Obtener todas las tablas de la base de datos
            $result = $conn->query("SHOW TABLES");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {
                    $table = $row[0];
                    echo "<a href='abml.php?table=$table'>" . ucfirst($table) . "</a>";
                }
            } else {
                echo "No se encontraron tablas en la base de datos.";
            }
            ?>
        </div>
        <a href="#">Orders</a>
        <a href="#">Products</a>
        <a href="#">Customers</a>
        <a href="#">Reports</a>
        <a href="#">Integrations</a>
        <a href="#">Saved reports</a>
    </div>

    <div class="main-content">
        <center>
            <h1>Contenido Principal</h1>
            <p>Aquí va tu contenido principal.</p>
        </center>
    </div>

    <script>
        // Script para manejar el acordeón
        var acc = document.getElementsByClassName("accordion");
        for (var i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    </script>

</body>
</html>
