<?php
include '../conexion.php';

echo "<h2>Verificando Datos de la Base de Datos</h2>";

// Verificar productos
echo "<h3>Productos en la Base de Datos:</h3>";
$sql_productos = "SELECT * FROM productos ORDER BY id";
$stmt_productos = $pdo->prepare($sql_productos);
$stmt_productos->execute();
$productos = $stmt_productos->fetchAll(PDO::FETCH_ASSOC);

echo "<p>Total de productos: " . count($productos) . "</p>";

if (empty($productos)) {
    echo "<p style='color: red;'>¡No hay productos en la base de datos!</p>";
    echo "<p><a href='../agregar_productos_simple.php'>← Agregar productos de ejemplo</a></p>";
} else {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th>ID</th>";
    echo "<th>Nombre</th>";
    echo "<th>Categoría ID</th>";
    echo "<th>Precio</th>";
    echo "<th>Stock</th>";
    echo "<th>Imagen</th>";
    echo "<th>Descripción</th>";
    echo "</tr>";
    
    foreach ($productos as $producto) {
        echo "<tr>";
        echo "<td>" . $producto['id'] . "</td>";
        echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
        echo "<td>" . $producto['categoria_id'] . "</td>";
        echo "<td>$" . number_format($producto['precio'], 0, ',', '.') . "</td>";
        echo "<td>" . $producto['stock'] . "</td>";
        echo "<td>" . htmlspecialchars($producto['imagen']) . "</td>";
        echo "<td>" . htmlspecialchars(substr($producto['descripcion'], 0, 50)) . "...</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Verificar categorías
echo "<h3>Categorías en la Base de Datos:</h3>";
$sql_categorias = "SELECT * FROM categorias ORDER BY id";
$stmt_categorias = $pdo->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

echo "<p>Total de categorías: " . count($categorias) . "</p>";

if (empty($categorias)) {
    echo "<p style='color: red;'>¡No hay categorías en la base de datos!</p>";
} else {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th>ID</th>";
    echo "<th>Nombre</th>";
    echo "</tr>";
    
    foreach ($categorias as $categoria) {
        echo "<tr>";
        echo "<td>" . $categoria['id'] . "</td>";
        echo "<td>" . htmlspecialchars($categoria['nombre']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Verificar productos con sus categorías
echo "<h3>Productos con sus Categorías:</h3>";
$sql_completo = "SELECT productos.*, categorias.nombre AS nombre_categoria 
                 FROM productos 
                 INNER JOIN categorias ON productos.categoria_id = categorias.id 
                 ORDER BY productos.id";
$stmt_completo = $pdo->prepare($sql_completo);
$stmt_completo->execute();
$productos_completos = $stmt_completo->fetchAll(PDO::FETCH_ASSOC);

echo "<p>Productos con categorías: " . count($productos_completos) . "</p>";

if (empty($productos_completos)) {
    echo "<p style='color: red;'>¡No hay productos con categorías válidas!</p>";
} else {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th>ID</th>";
    echo "<th>Nombre</th>";
    echo "<th>Categoría</th>";
    echo "<th>Precio</th>";
    echo "<th>Stock</th>";
    echo "<th>Imagen</th>";
    echo "</tr>";
    
    foreach ($productos_completos as $producto) {
        echo "<tr>";
        echo "<td>" . $producto['id'] . "</td>";
        echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($producto['nombre_categoria']) . "</td>";
        echo "<td>$" . number_format($producto['precio'], 0, ',', '.') . "</td>";
        echo "<td>" . $producto['stock'] . "</td>";
        echo "<td>" . htmlspecialchars($producto['imagen']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Verificar imágenes en uploads
echo "<h3>Imágenes en carpeta uploads:</h3>";
$uploads_dir = "../uploads/";
if (is_dir($uploads_dir)) {
    $imagenes = glob($uploads_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    echo "<p>Total de imágenes: " . count($imagenes) . "</p>";
    
    if (!empty($imagenes)) {
        echo "<div style='display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px;'>";
        foreach ($imagenes as $imagen) {
            $nombre_archivo = basename($imagen);
            echo "<div style='border: 1px solid #ccc; padding: 10px; text-align: center;'>";
            echo "<img src='../uploads/" . $nombre_archivo . "' style='max-width: 100px; max-height: 100px;' alt='" . $nombre_archivo . "'>";
            echo "<p style='font-size: 12px;'>" . $nombre_archivo . "</p>";
            echo "</div>";
        }
        echo "</div>";
    }
} else {
    echo "<p style='color: red;'>La carpeta uploads no existe</p>";
}

echo "<p><a href='../agregar_productos_simple.php'>← Agregar productos de ejemplo</a></p>";
echo "<p><a href='../index.php'>← Ir al inicio</a></p>";
?> 