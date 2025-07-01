<?php
include '../../conexion.php'; // Incluir la conexión PDO

// Consultar categorías de la base de datos
$query = "SELECT * FROM categorias";
$stmt = $pdo->prepare($query);
$stmt->execute();
$categorias = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="../../frontend/admin/crear_producto.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Gidole&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
</head>
<body>
    <form action="guardar_producto.php" method="POST" enctype="multipart/form-data">
        <h1>Crear Producto</h1>

        <label for="nombre">Nombre del Producto:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="stock">Cantidad en Stock:</label>
        <input type="number" name="stock" id="stock" required min="1">

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required></textarea>

        <label for="categoria">Categoría:</label>
        <select name="categoria" id="categoria" required>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['nombre']); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="precio">Precio (COP):</label>
        <input type="number" name="precio" id="precio" required min="1">

        <label for="imagen">Imagen del Producto:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*" required>

        <div class="form-buttons">
            <a href="gestion_productos.php" class="btn-regresar">Regresar</a>
            <button type="submit">Guardar Producto</button>
        </div>
    </form>
</body>
</html>
