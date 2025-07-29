<?php
include '../conexion.php';

echo "<h2>Limpiando y Agregando Productos de PVC</h2>";

// Paso 1: Limpiar productos existentes
echo "<h3>Paso 1: Limpiando productos existentes...</h3>";
$sql_delete = "DELETE FROM productos";
$stmt_delete = $pdo->prepare($sql_delete);
$stmt_delete->execute();
echo "<p style='color: green;'>✓ Productos eliminados</p>";

// Paso 2: Verificar categorías
echo "<h3>Paso 2: Verificando categorías...</h3>";
$sql_categorias = "SELECT * FROM categorias ORDER BY id";
$stmt_categorias = $pdo->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

if (empty($categorias)) {
    echo "<p style='color: red;'>✗ No hay categorías. Primero agrega categorías desde el panel de administración.</p>";
    echo "<p><a href='../admin/categorias/gestion_categorias.php'>← Ir a Gestión de Categorías</a></p>";
    exit;
}

echo "<p>✓ Categorías encontradas: " . count($categorias) . "</p>";
foreach ($categorias as $cat) {
    echo "<p>- " . htmlspecialchars($cat['nombre']) . " (ID: " . $cat['id'] . ")</p>";
}

// Paso 3: Agregar productos de PVC reales
echo "<h3>Paso 3: Agregando productos de PVC...</h3>";

$productos_pvc = [
    // Tubos PVC
    [
        'nombre' => 'Tubo PVC 1/2" x 6m',
        'descripcion' => 'Tubo de PVC de 1/2 pulgada, 6 metros de longitud. Ideal para instalaciones hidráulicas domésticas.',
        'precio' => 8500,
        'stock' => 50,
        'categoria_id' => 1, // Tubos
        'imagen' => 'tubo-pvc-12-6m.jpg'
    ],
    [
        'nombre' => 'Tubo PVC 3/4" x 6m',
        'descripcion' => 'Tubo de PVC de 3/4 pulgada, 6 metros. Perfecto para sistemas de riego y plomería.',
        'precio' => 12000,
        'stock' => 40,
        'categoria_id' => 1, // Tubos
        'imagen' => 'tubo-pvc-34-6m.jpg'
    ],
    [
        'nombre' => 'Tubo PVC 1" x 6m',
        'descripcion' => 'Tubo de PVC de 1 pulgada, 6 metros. Para instalaciones comerciales e industriales.',
        'precio' => 18000,
        'stock' => 30,
        'categoria_id' => 1, // Tubos
        'imagen' => 'tubo-pvc-1-6m.jpg'
    ],
    
    // Conectores
    [
        'nombre' => 'Codo PVC 90° 1/2"',
        'descripcion' => 'Codo de PVC de 90 grados para tubo de 1/2 pulgada. Conexión perfecta para cambios de dirección.',
        'precio' => 2500,
        'stock' => 100,
        'categoria_id' => 2, // Conectores
        'imagen' => 'codo-pvc-90-12.jpg'
    ],
    [
        'nombre' => 'Tee PVC 1/2"',
        'descripcion' => 'Conector en T para tubo de 1/2 pulgada. Permite crear ramificaciones en la tubería.',
        'precio' => 3000,
        'stock' => 80,
        'categoria_id' => 2, // Conectores
        'imagen' => 'tee-pvc-12.jpg'
    ],
    [
        'nombre' => 'Unión PVC 3/4"',
        'descripcion' => 'Unión recta para tubo de 3/4 pulgada. Conexión simple y efectiva.',
        'precio' => 1800,
        'stock' => 120,
        'categoria_id' => 2, // Conectores
        'imagen' => 'union-pvc-34.jpg'
    ],
    
    // Láminas
    [
        'nombre' => 'Lámina PVC 2.4m x 1.2m',
        'descripcion' => 'Lámina de PVC de 2.4 metros por 1.2 metros. Ideal para techos y divisiones.',
        'precio' => 45000,
        'stock' => 15,
        'categoria_id' => 3, // Láminas
        'imagen' => 'lamina-pvc-24x12.jpg'
    ],
    [
        'nombre' => 'Lámina PVC 3m x 1.5m',
        'descripcion' => 'Lámina de PVC de 3 metros por 1.5 metros. Para proyectos de mayor envergadura.',
        'precio' => 65000,
        'stock' => 10,
        'categoria_id' => 3, // Láminas
        'imagen' => 'lamina-pvc-3x15.jpg'
    ],
    
    // Cemento
    [
        'nombre' => 'Cemento PVC 250ml',
        'descripcion' => 'Cemento para PVC de 250ml. Adhesivo especial para uniones de tubería PVC.',
        'precio' => 8500,
        'stock' => 60,
        'categoria_id' => 4, // Cemento
        'imagen' => 'cemento-pvc-250ml.jpg'
    ],
    [
        'nombre' => 'Cemento PVC 500ml',
        'descripcion' => 'Cemento para PVC de 500ml. Mayor volumen para proyectos extensos.',
        'precio' => 15000,
        'stock' => 40,
        'categoria_id' => 4, // Cemento
        'imagen' => 'cemento-pvc-500ml.jpg'
    ],
    
    // Tornillos
    [
        'nombre' => 'Tornillo PVC 2" x 1/4"',
        'descripcion' => 'Tornillo de PVC de 2 pulgadas con cabeza de 1/4 pulgada. Para fijaciones en PVC.',
        'precio' => 800,
        'stock' => 200,
        'categoria_id' => 5, // Tornillos
        'imagen' => 'tornillo-pvc-2x14.jpg'
    ],
    [
        'nombre' => 'Tornillo PVC 3" x 3/8"',
        'descripcion' => 'Tornillo de PVC de 3 pulgadas con cabeza de 3/8 pulgadas. Para aplicaciones más robustas.',
        'precio' => 1200,
        'stock' => 150,
        'categoria_id' => 5, // Tornillos
        'imagen' => 'tornillo-pvc-3x38.jpg'
    ],
    
    // Puntillas
    [
        'nombre' => 'Puntilla PVC 1"',
        'descripcion' => 'Puntilla de PVC de 1 pulgada. Para fijaciones ligeras en materiales plásticos.',
        'precio' => 300,
        'stock' => 500,
        'categoria_id' => 6, // Puntillas
        'imagen' => 'puntilla-pvc-1.jpg'
    ],
    [
        'nombre' => 'Puntilla PVC 1.5"',
        'descripcion' => 'Puntilla de PVC de 1.5 pulgadas. Mayor penetración para fijaciones más firmes.',
        'precio' => 450,
        'stock' => 400,
        'categoria_id' => 6, // Puntillas
        'imagen' => 'puntilla-pvc-15.jpg'
    ]
];

$productos_agregados = 0;
$errores = 0;

foreach ($productos_pvc as $producto) {
    // Verificar si la categoría existe
    $sql_check = "SELECT id FROM categorias WHERE id = :categoria_id";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute(['categoria_id' => $producto['categoria_id']]);
    
    if ($stmt_check->fetch()) {
        // Insertar producto
        $sql_insert = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) 
                       VALUES (:nombre, :descripcion, :precio, :stock, :categoria_id, :imagen)";
        $stmt_insert = $pdo->prepare($sql_insert);
        
        if ($stmt_insert->execute($producto)) {
            echo "<p style='color: green;'>✓ " . htmlspecialchars($producto['nombre']) . "</p>";
            $productos_agregados++;
        } else {
            echo "<p style='color: red;'>✗ Error al agregar: " . htmlspecialchars($producto['nombre']) . "</p>";
            $errores++;
        }
    } else {
        echo "<p style='color: orange;'>⚠ Categoría no encontrada para: " . htmlspecialchars($producto['nombre']) . "</p>";
        $errores++;
    }
}

echo "<h3>Resumen:</h3>";
echo "<p>Productos agregados: " . $productos_agregados . "</p>";
echo "<p>Errores: " . $errores . "</p>";

// Paso 4: Generar imágenes placeholder
echo "<h3>Paso 4: Generando imágenes placeholder...</h3>";
$sql_productos = "SELECT * FROM productos ORDER BY id";
$stmt_productos = $pdo->prepare($sql_productos);
$stmt_productos->execute();
$productos_finales = $stmt_productos->fetchAll(PDO::FETCH_ASSOC);

$imagenes_creadas = 0;
foreach ($productos_finales as $producto) {
    $ruta_imagen = "../uploads/" . $producto['imagen'];
    
    if (!file_exists($ruta_imagen)) {
        // Crear imagen placeholder
        $imagen = imagecreate(300, 200);
        $fondo = imagecolorallocate($imagen, 240, 240, 240);
        $texto_color = imagecolorallocate($imagen, 100, 100, 100);
        $borde = imagecolorallocate($imagen, 200, 200, 200);
        
        imagerectangle($imagen, 0, 0, 299, 199, $borde);
        
        $texto = $producto['nombre'];
        $fuente = 5;
        $texto_ancho = strlen($texto) * imagefontwidth($fuente);
        $texto_alto = imagefontheight($fuente);
        
        $x = (300 - $texto_ancho) / 2;
        $y = (200 - $texto_alto) / 2;
        
        imagestring($imagen, $fuente, $x, $y, $texto, $texto_color);
        
        if (imagejpeg($imagen, $ruta_imagen, 80)) {
            echo "<p style='color: green;'>✓ Imagen creada: " . htmlspecialchars($producto['imagen']) . "</p>";
            $imagenes_creadas++;
        }
        
        imagedestroy($imagen);
    }
}

echo "<h3>Resultado Final:</h3>";
echo "<p>✓ Productos agregados: " . $productos_agregados . "</p>";
echo "<p>✓ Imágenes creadas: " . $imagenes_creadas . "</p>";
echo "<p><a href='../index.php'>← Ir al inicio</a></p>";
echo "<p><a href='verificar_datos.php'>← Verificar datos</a></p>";
?> 