<?php
// Crear imagen de placeholder para productos sin imagen
function generarImagenPlaceholder($texto, $ancho = 300, $alto = 200) {
    // Crear imagen
    $imagen = imagecreate($ancho, $alto);
    
    // Colores
    $fondo = imagecolorallocate($imagen, 240, 240, 240); // Gris claro
    $texto_color = imagecolorallocate($imagen, 100, 100, 100); // Gris oscuro
    $borde = imagecolorallocate($imagen, 200, 200, 200); // Gris medio
    
    // Dibujar borde
    imagerectangle($imagen, 0, 0, $ancho-1, $alto-1, $borde);
    
    // Agregar texto
    $fuente = 5; // Fuente del sistema
    $texto_ancho = strlen($texto) * imagefontwidth($fuente);
    $texto_alto = imagefontheight($fuente);
    
    $x = ($ancho - $texto_ancho) / 2;
    $y = ($alto - $texto_alto) / 2;
    
    imagestring($imagen, $fuente, $x, $y, $texto, $texto_color);
    
    return $imagen;
}

// Función para guardar imagen placeholder
function guardarImagenPlaceholder($nombre_producto, $categoria) {
    $uploads_dir = "../uploads/";
    
    // Crear directorio si no existe
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0755, true);
    }
    
    // Generar nombre de archivo
    $nombre_archivo = strtolower(str_replace(' ', '-', $nombre_producto)) . '-placeholder.jpg';
    $ruta_completa = $uploads_dir . $nombre_archivo;
    
    // Crear imagen placeholder
    $imagen = generarImagenPlaceholder($nombre_producto);
    
    // Guardar imagen
    imagejpeg($imagen, $ruta_completa, 80);
    imagedestroy($imagen);
    
    return $nombre_archivo;
}

// Función para verificar y crear imágenes faltantes
function verificarImagenesProductos() {
    include '../conexion.php';
    
    $sql = "SELECT * FROM productos";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $imagenes_creadas = 0;
    
    foreach ($productos as $producto) {
        $ruta_imagen = "../uploads/" . $producto['imagen'];
        
        // Si la imagen no existe, crear placeholder
        if (!file_exists($ruta_imagen)) {
            $nueva_imagen = guardarImagenPlaceholder($producto['nombre'], $producto['categoria_id']);
            
            // Actualizar la BD con el nuevo nombre de imagen
            $sql_update = "UPDATE productos SET imagen = :imagen WHERE id = :id";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([
                'imagen' => $nueva_imagen,
                'id' => $producto['id']
            ]);
            
            echo "<p style='color: green;'>✓ Imagen creada para: " . htmlspecialchars($producto['nombre']) . " -> " . $nueva_imagen . "</p>";
            $imagenes_creadas++;
        } else {
            echo "<p style='color: blue;'>✓ Imagen existe: " . htmlspecialchars($producto['imagen']) . "</p>";
        }
    }
    
    return $imagenes_creadas;
}

// Ejecutar verificación
echo "<h2>Verificando Imágenes de Productos</h2>";
$creadas = verificarImagenesProductos();
echo "<h3>Resumen:</h3>";
echo "<p>Imágenes creadas: " . $creadas . "</p>";
echo "<p><a href='ver_productos_bd.php'>← Ver productos</a></p>";
?> 