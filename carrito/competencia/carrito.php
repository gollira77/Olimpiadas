<?php
// Incluye el archivo de conexión a la base de datos
require("conexion.php");

// Manejar la acción del formulario (incrementar/decrementar cantidad o eliminar producto)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $product_name = $_POST['product_name'];
        $action = $_POST['action'];

        // Obtener la cantidad actual del producto
        $consulta = "SELECT cantidad FROM productos WHERE productos = '$product_name'";
        $resultado = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_assoc($resultado);
        $cantidad_actual = $fila['cantidad'];

        // Actualizar la cantidad basada en la acción
        if ($action == 'increase') {
            $nueva_cantidad = $cantidad_actual + 1;
        } elseif ($action == 'decrease') {
            $nueva_cantidad = max($cantidad_actual - 1, 1); // Asegura que la cantidad nunca sea menor de 1
        }

        // Actualizar la cantidad en la base de datos
        $actualizar = "UPDATE productos SET cantidad = $nueva_cantidad WHERE productos = '$product_name'";
        mysqli_query($conexion, $actualizar);
    } elseif (isset($_POST['delete'])) {
        $product_id = $_POST['id_producto'];

        // Eliminar el producto basado en el ID
        $eliminar = "DELETE FROM productos WHERE id = $product_id";
        mysqli_query($conexion, $eliminar);
    }

    // Redireccionar para evitar el resubmit del formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener los productos para mostrarlos en la tabla
$consulta = "SELECT id, productos, descripcion, precio, imagen, id_categoria, activo FROM productos";
$resultado = mysqli_query($conexion, $consulta);

$subtotal = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 24px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #555;
        }

        tr {
            border-bottom: 1px solid #ddd;
        }

        img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
        }

        .quantity-controls button {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 4px;
            cursor: pointer;
        }

        .quantity-controls span {
            margin: 0 10px;
        }

        .total-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 24px;
        }

        .total-box {
            background-color: #f7f7f7;
            padding: 24px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
        }

        .total-box div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .total-box div span {
            font-weight: bold;
        }

        .total-box .total {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .checkout-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px;
            width: 100%;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 16px;
        }

        .checkout-button:hover {
            background-color: #0056b3;
        }

        .remove-button {
            padding: 5px 5px;
            border-radius: 5px;
            border: 1px solid white;
            background-color: red;
            color: white;
        }

        img {
            width: 40px;
            height: 40px;
        }

        button {
            border-radius: 3px;
            padding: 7px 7px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Carrito de Compra</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Precio Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                        <?php $precio_total = $fila['precio'] * $fila['cantidad']; ?>
                        <?php $subtotal += $precio_total; ?>
                        <tr>
                            <td><img src="data:image/jpeg;base64,<?php echo base64_encode($fila['imagen']); ?>" alt="Imagen"></td>
                            <td><?php echo $fila['productos']; ?></td>
                            <td>
                                <div class="quantity-controls">
                                    <form method="post" action="">
                                        <input type="hidden" name="product_name" value="<?php echo $fila['productos']; ?>">
                                        <button type="submit" name="action" value="decrease">-</button>
                                        <span><?php echo $fila['cantidad']; ?></span>
                                        <button type="submit" name="action" value="increase">+</button>
                                    </form>
                                </div>
                            </td>
                            <td class="text-right">$<?php echo number_format($fila['precio'], 2); ?></td>
                            <td class="text-right">$<?php echo number_format($precio_total, 2); ?></td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="id_producto" value="<?php echo $fila['id']; ?>">
                                    <button type="submit" name="delete" class="remove-button">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="total-container">
            <div class="total-box">
                <div>
                    <span>Subtotal:</span>
                    <span>$<?php echo number_format($subtotal, 2); ?></span>
                </div>
                <?php
                $impuestos = $subtotal * 0.16; // Suponiendo un impuesto del 16%
                $total = $subtotal + $impuestos;
                ?>
                <div>
                    <span>Envio:</span>
                    <span>$<?php echo number_format($impuestos, 2); ?></span>
                </div>
                <div class="total">
                    <span>Total:</span>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
                <button class="checkout-button">Proceder al Pago</button>
            </div>
        </div>
    </div>
</body>

</html>
