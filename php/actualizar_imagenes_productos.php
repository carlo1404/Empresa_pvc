<?php
include '../conexion.php';

echo "<h2>Actualizando Imágenes de Productos</h2>";

// Obtener todos los productos
$sql = "SELECT * FROM productos ORDER BY id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$actualizados = 0;
$errores = 0;

foreach ($productos as $producto) {
    $ruta_imagen = "../uploads/" . $producto['imagen'];
    
    // Verificar si la imagen existe
    if (!file_exists($ruta_imagen)) {
        // Crear nombre de imagen basado en el producto
        $nuevo_nombre = strtolower(str_replace(' ', '-', $producto['nombre'])) . '.jpg';
        $nuevo_nombre = preg_replace('/[^a-z0-9\-]/', '', $nuevo_nombre);
        
        // Crear imagen placeholder
        $imagen = imagecreate(300, 200);
        $fondo = imagecolorallocate($imagen, 240, 240, 240);
        $texto_color = imagecolorallocate($imagen, 100, 100, 100);
        $borde = imagecolorallocate($imagen, 200, 200, 200);
        
        // Dibujar borde
        imagerectangle($imagen, 0, 0, 299, 199, $borde);
        
        // Agregar texto del producto
        $texto = $producto['nombre'];
        $fuente = 5;
        $texto_ancho = strlen($texto) * imagefontwidth($fuente);
        $texto_alto = imagefontheight($fuente);
        
        $x = (300 - $texto_ancho) / 2;
        $y = (200 - $texto_alto) / 2;
        
        imagestring($imagen, $fuente, $x, $y, $texto, $texto_color);
        
        // Guardar imagen
        $ruta_nueva = "../uploads/" . $nuevo_nombre;
        if (imagejpeg($imagen, $ruta_nueva, 80)) {
            // Actualizar base de datos
            $sql_update = "UPDATE productos SET imagen = :imagen WHERE id = :id";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([
                'imagen' => $nuevo_nombre,
                'id' => $producto['id']
            ]);
            
            echo "<p style='color: green;'>✓ Imagen creada para: " . htmlspecialchars($producto['nombre']) . " -> " . $nuevo_nombre . "</p>";
            $actualizados++;
        } else {
            echo "<p style='color: red;'>✗ Error al crear imagen para: " . htmlspecialchars($producto['nombre']) . "</p>";
            $errores++;
        }
        
        imagedestroy($imagen);
    } else {
        echo "<p style='color: blue;'>✓ Imagen existe: " . htmlspecialchars($producto['imagen']) . "</p>";
    }
}

echo "<h3>Resumen:</h3>";
echo "<p>Imágenes actualizadas: " . $actualizados . "</p>";
echo "<p>Errores: " . $errores . "</p>";

// Mostrar productos actualizados
echo "<h3>Productos Actualizados:</h3>";
$sql_final = "SELECT * FROM productos ORDER BY id";
$stmt_final = $pdo->prepare($sql_final);
$stmt_final->execute();
$productos_finales = $stmt_final->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr style='background-color: #f0f0f0;'>";
echo "<th>ID</th>";
echo "<th>Nombre</th>";
echo "<th>Imagen</th>";
echo "<th>Estado</th>";
echo "</tr>";

foreach ($productos_finales as $producto) {
    $ruta_imagen = "../uploads/" . $producto['imagen'];
    $existe = file_exists($ruta_imagen);
    
    echo "<tr>";
    echo "<td>" . $producto['id'] . "</td>";
    echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
    echo "<td>" . htmlspecialchars($producto['imagen']) . "</td>";
    echo "<td style='color: " . ($existe ? 'green' : 'red') . ";'>" . ($existe ? '✓ Existe' : '✗ No existe') . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<p><a href='ver_productos_bd.php'>← Ver todos los productos</a></p>";
?> 