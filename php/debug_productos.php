<?php
include '../conexion.php';

echo "<h2>Debug de Productos</h2>";

// Consultar todos los productos con sus categorías
$sql = "SELECT productos.*, categorias.nombre AS nombre_categoria 
        FROM productos 
        INNER JOIN categorias ON productos.categoria_id = categorias.id";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h3>Total de productos: " . count($productos) . "</h3>";

foreach ($productos as $producto) {
    echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
    echo "<h4>Producto ID: " . $producto['id'] . "</h4>";
    echo "<p><strong>Nombre:</strong> " . htmlspecialchars($producto['nombre']) . "</p>";
    echo "<p><strong>Categoría:</strong> " . htmlspecialchars($producto['nombre_categoria']) . "</p>";
    echo "<p><strong>Imagen:</strong> " . htmlspecialchars($producto['imagen']) . "</p>";
    
    // Verificar si la imagen existe
    $ruta_imagen = "../uploads/" . $producto['imagen'];
    if (file_exists($ruta_imagen)) {
        echo "<p style='color: green;'>✓ Imagen existe: " . $ruta_imagen . "</p>";
        echo "<img src='../uploads/" . htmlspecialchars($producto['imagen']) . "' style='max-width: 100px; max-height: 100px;'>";
    } else {
        echo "<p style='color: red;'>✗ Imagen NO existe: " . $ruta_imagen . "</p>";
    }
    
    echo "</div>";
}

// Verificar categorías
echo "<h3>Categorías disponibles:</h3>";
$sql_categorias = "SELECT * FROM categorias ORDER BY id";
$stmt_categorias = $pdo->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

foreach ($categorias as $categoria) {
    echo "<p>ID: " . $categoria['id'] . " - Nombre: " . htmlspecialchars($categoria['nombre']) . "</p>";
}
?> 