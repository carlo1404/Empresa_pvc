<?php
include '../conexion.php';

echo "<h2>Productos en la Base de Datos</h2>";

// Consultar todos los productos con sus categorías
$sql = "SELECT productos.*, categorias.nombre AS nombre_categoria 
        FROM productos 
        INNER JOIN categorias ON productos.categoria_id = categorias.id
        ORDER BY productos.id";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h3>Total de productos: " . count($productos) . "</h3>";

if (empty($productos)) {
    echo "<p style='color: red;'>No hay productos en la base de datos.</p>";
} else {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th>ID</th>";
    echo "<th>Nombre</th>";
    echo "<th>Categoría</th>";
    echo "<th>Precio</th>";
    echo "<th>Stock</th>";
    echo "<th>Imagen</th>";
    echo "<th>Descripción</th>";
    echo "<th>Fecha Creación</th>";
    echo "<th>Acciones</th>";
    echo "</tr>";
    
    foreach ($productos as $producto) {
        echo "<tr>";
        echo "<td>" . $producto['id'] . "</td>";
        echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($producto['nombre_categoria']) . "</td>";
        echo "<td>COP $" . number_format($producto['precio'], 0, ',', '.') . "</td>";
        echo "<td>" . $producto['stock'] . "</td>";
        echo "<td>" . htmlspecialchars($producto['imagen']) . "</td>";
        echo "<td>" . htmlspecialchars(substr($producto['descripcion'], 0, 50)) . "...</td>";
        echo "<td>" . $producto['fecha_creacion'] . "</td>";
        echo "<td>";
        echo "<a href='eliminar_producto_test.php?id=" . $producto['id'] . "' onclick='return confirm(\"¿Eliminar este producto?\")' style='color: red;'>Eliminar</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Mostrar categorías disponibles
echo "<h3>Categorías Disponibles:</h3>";
$sql_categorias = "SELECT * FROM categorias ORDER BY id";
$stmt_categorias = $pdo->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

echo "<ul>";
foreach ($categorias as $categoria) {
    echo "<li>ID: " . $categoria['id'] . " - Nombre: " . htmlspecialchars($categoria['nombre']) . "</li>";
}
echo "</ul>";

// Mostrar imágenes en uploads
echo "<h3>Imágenes en carpeta uploads:</h3>";
$uploads_dir = "../uploads/";
if (is_dir($uploads_dir)) {
    $files = scandir($uploads_dir);
    $image_files = array_filter($files, function($file) {
        return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']);
    });
    
    if (empty($image_files)) {
        echo "<p style='color: orange;'>No hay imágenes en la carpeta uploads.</p>";
    } else {
        echo "<ul>";
        foreach ($image_files as $file) {
            echo "<li>" . htmlspecialchars($file) . "</li>";
        }
        echo "</ul>";
    }
} else {
    echo "<p style='color: red;'>La carpeta uploads no existe.</p>";
}
?> 