<?php
require 'config.php';

list($productos, $codigo) = peticionAPI('GET');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos del Minimarket</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #2c3e50; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        a { text-decoration: none; color: #3498db; margin-right: 10px; }
        .btn-nuevo { display: inline-block; background: #2ecc71; color: white; padding: 8px 16px; border-radius: 4px; margin: 10px 0; }
        .btn-eliminar { color: #e74c3c; }
        .error { color: #e74c3c; padding: 10px; background: #fdecea; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Productos del Minimarket</h1>
    
    <a href="crearProducto.php" class="btn-nuevo">Agregar Nuevo Producto</a>

    <?php if ($codigo !== 200): ?>
        <p class="error">No se pudo conectar con el servidor. Verifica que el backend esté encendido.</p>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Proveedor</th>
            <th>Fecha de Vencimiento</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= htmlspecialchars($p['proveedor']) ?></td>
                <td><?= $p['fechaVencimiento'] ?></td>
                <td>$ <?= number_format($p['precio'], 2, ',', '.') ?></td>
                <td><?= $p['stock'] ?></td>
                <td>
                    <a href="editarProducto.php?id=<?= $p['id'] ?>">Editar</a>
                    <a href="eliminarProducto.php?id=<?= $p['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Seguro que quieres eliminar este producto?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">
                    No hay productos registrados. ¡Agrega el primero!
                </td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>