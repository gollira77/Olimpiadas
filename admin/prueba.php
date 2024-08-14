<?php
// Suponiendo que tienes una conexión a la base de datos ya establecida
require("conexion.php");
// Consulta para obtener todas las imágenes de los productos
$query = "SELECT Id, Imagen FROM Productos";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $imageData = $row['Imagen'];
        $productId = $row['Id'];
        
        if (!empty($imageData)) {
            $base64Image = base64_encode($imageData);
            // Asegúrate de usar el tipo correcto de imagen, aquí se asume JPEG
            echo "<div>";
            echo "<h3>Producto ID: $productId</h3>";
            echo "<img src='data:image/jpeg;base64,$base64Image' alt='Imagen del producto' width='300'>";
            echo "</div>";
        } else {
            echo "<div>";
            echo "<h3>Producto ID: $productId</h3>";
            echo "No image data found.";
            echo "</div>";
        }
    }
} else {
    echo "Error en la consulta: " . mysqli_error($conn);
}
?>
