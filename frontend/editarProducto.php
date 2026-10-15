<?php
require 'config.php';
$id = $_GET['id'] ?? 0;

list($producto, $codigo) = peticionAPI('GET', "/$id");

if ($codigo !== 200 || !$producto) {
    echo "<p style='color:red;'>⚠️ No se encontró el producto. Código: $codigo</p>";
    echo "<a href='index.php'>← Volver al listado</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre' => trim($_POST['nombre']),
        'proveedor' => trim($_POST['proveedor']),
        'fechaVencimiento' => $_POST['fecha_vencimiento'],
        'precio' => (float)$_POST['precio'],
        'stock' => (int)$_POST['stock']
    ];
    peticionAPI('PUT', "/$id", $datos);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto #<?= $id ?></title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 30px auto; padding: 0 20px; }
        h1 { color: #2c3e50; }
        form { background: #f9f9f9; padding: 25px; border-radius: 8px; }
        p { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #2980b9; }
        .cancelar { background: #95a5a6; margin-left: 10px; }
        .cancelar:hover { background: #7f8c8d; }
    </style>
</head>
<body>
    <h1>Editar Producto #<?= $id ?></h1>

    <form method="post">
        <p>
            <label for="nombre">Nombre del producto:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
        </p>
        <p>
            <label for="proveedor">Proveedor:</label>
            <input type="text" id="proveedor" name="proveedor" value="<?= htmlspecialchars($producto['proveedor']) ?>" required>
        </p>
        <p>
            <label for="fecha_vencimiento">Fecha de vencimiento:</label>
            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="<?= htmlspecialchars($producto['fechaVencimiento']) ?>" required>
        </p>
        <p>
            <label for="precio">Precio ($):</label>
            <input type="number" step="0.01" min="0" id="precio" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>" required>
        </p>
        <p>
            <label for="stock">Cantidad en stock:</label>
            <input type="number" min="0" id="stock" name="stock" value="<?= htmlspecialchars($producto['stock']) ?>" required>
        </p>
        <p>
            <button type="submit">Actualizar Producto</button>
            <a href="index.php" style="color:white; text-decoration:none;"><button type="button" class="cancelar">Cancelar</button></a>
        </p>
    </form>
</body>
</html>