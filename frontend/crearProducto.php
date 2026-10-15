<?php
require 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre' => trim($_POST['nombre']),
        'proveedor' => trim($_POST['proveedor']),
        'fechaVencimiento' => $_POST['fecha_vencimiento'],
        'precio' => (float)$_POST['precio'],
        'stock' => (int)$_POST['stock']
    ];

    list($respuesta, $codigo) = peticionAPI('POST', '', $datos);

    if ($codigo === 201) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Error al registrar. Verifica que todos los campos estén completos y válidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 30px auto; padding: 0 20px; }
        h1 { color: #2c3e50; }
        form { background: #f9f9f9; padding: 25px; border-radius: 8px; }
        p { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #27ae60; }
        .cancelar { background: #95a5a6; margin-left: 10px; }
        .cancelar:hover { background: #7f8c8d; }
        .error { color: #e74c3c; padding: 10px; background: #fdecea; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Nuevo Producto</h1>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
        <p>
            <label for="nombre">Nombre del producto:</label>
            <input type="text" id="nombre" name="nombre" required>
        </p>
        <p>
            <label for="proveedor">Proveedor:</label>
            <input type="text" id="proveedor" name="proveedor" required>
        </p>
        <p>
            <label for="fecha_vencimiento">Fecha de vencimiento:</label>
            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" required>
        </p>
        <p>
            <label for="precio">Precio:</label>
            <input type="number" step="0.01" min="0" id="precio" name="precio" required>
        </p>
        <p>
            <label for="stock">Cantidad en stock:</label>
            <input type="number" min="0" id="stock" name="stock" required>
        </p>
        <p>
            <button type="submit">Guardar Producto</button>
            <a href="index.php" style="color:white; text-decoration:none;"><button type="button" class="cancelar">Cancelar</button></a>
        </p>
    </form>
</body>
</html>