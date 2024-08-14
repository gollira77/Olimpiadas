<?php
    $host = "localhost"; // Cambia si es necesario
    $usuario = "root"; // Cambia si es necesario
    $password = ""; // Cambia si es necesario
    $base_de_datos = "carrito_test"; // Cambia al nombre correcto de tu base de datos

    $conexion = mysqli_connect($host, $usuario, $password, $base_de_datos);

    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }
?>
