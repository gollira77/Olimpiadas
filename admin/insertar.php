<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Registro</title>
</head>
<body>

<?php
require("conexion.php");

$table = $_GET['table'] ?? '';

echo "<h1>Agregar nuevo registro a " . ucfirst($table) . "</h1>";
$result = $conn->query("DESCRIBE $table");
echo "<form method='post' action='guardar.php?action=insert&table=$table' enctype='multipart/form-data'>";
while ($row = $result->fetch_assoc()) {
    if ($row['Field'] != 'id') {
        if ($row['Field'] == 'imagen') {
            echo "<label>" . ucfirst($row['Field']) . ": </label>";
            echo "<input type='file' name='" . $row['Field'] . "'><br>";
        } else {
            echo "<label>" . ucfirst($row['Field']) . ": </label>";
            echo "<input type='text' name='" . $row['Field'] . "' required><br>";
        }
    }
}
echo "<input type='submit' value='Agregar'>";
echo "</form>";

$conn->close();
?>

<a href="abml.php?table=<?php echo htmlspecialchars($table); ?>">volver</a>

</body>
</html>
