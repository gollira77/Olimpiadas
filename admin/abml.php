<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABML</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .container {
            margin-left: 300px;
            padding: 20px;
            width: calc(100% - 300px);
        }

        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .container a {
            text-decoration: none;
            color: #007bff;
        }

        .container a:hover {
            text-decoration: underline;
        }

        .container table {
            width: 100%;
            border-collapse: collapse;
        }

        .container table, .container th, .container td {
            border: 1px solid #ddd;
        }

        .container th, .container td {
            padding: 8px;
            text-align: left;
        }

        .container th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">

<?php
require("conexion.php");

$table = $_GET['table'] ?? '';

// Mostrar el título de la tabla
echo "<h1>Gestión de " . ucfirst($table) . "</h1>";

// Formulario para Alta (Insertar nuevos datos)
echo "<a href='insertar.php?table=$table'>Agregar nuevo registro</a><br><br>";

// Mostrar listado de registros
if ($table) {
    echo "<h2>Listado de registros en " . ucfirst($table) . "</h2>";
    $result = $conn->query("SELECT * FROM $table");

    if ($result->num_rows > 0) {
        echo "<table><tr>";
        $fields = $result->fetch_fields();
        foreach ($fields as $field) {
            echo "<th>" . ucfirst($field->name) . "</th>";
        }
        echo "<th>Acciones</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $key => $data) {
                if ($key == 'imagen' && !empty($data)) {
                    $imageData = base64_encode($data);
                    echo "<td><img src='data:image/jpeg;base64,$imageData' alt='Imagen' width='100'></td>";
                } else {
                    echo "<td>" . htmlspecialchars($data) . "</td>";
                }
            }
            echo "<td>
                    <a href='modificar.php?table=$table&id=" . $row['id'] . "'>Modificar</a> | 
                    <a href='guardar.php?action=delete&table=$table&id=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\")'>Eliminar</a>
                </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron datos.";
    }
} else {
    echo "Por favor, selecciona una tabla.";
}

$conn->close();
?>

<a href="principal.php">volver</a>

</div>

</body>
</html>
