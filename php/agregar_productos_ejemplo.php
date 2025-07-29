<?php
include '../conexion.php';

// Productos de ejemplo de PVC
$productos_ejemplo = [
    [
        'nombre' => 'Tubo PVC 1/2 pulgada',
        'descripcion' => 'Tubo de PVC de 1/2 pulgada, ideal para instalaciones de agua potable y riego.',
        'precio' => 8500,
        'stock' => 50,
        'categoria_id' => 1, // Asegúrate de que esta categoría exista
        'imagen' => 'tubo-pvc-1-2.jpg'
    ],
    [
        'nombre' => 'Tubo PVC 3/4 pulgada',
        'descripcion' => 'Tubo de PVC de 3/4 pulgada, resistente y duradero para proyectos de plomería.',
        'precio' => 12000,
        'stock' => 35,
        'categoria_id' => 1,
        'imagen' => 'tubo-pvc-3-4.jpg'
    ],
    [
        'nombre' => 'Tubo PVC 1 pulgada',
        'descripcion' => 'Tubo de PVC de 1 pulgada, perfecto para sistemas de drenaje y alcantarillado.',
        'precio' => 15000,
        'stock' => 25,
        'categoria_id' => 1,
        'imagen' => 'tubo-pvc-1.jpg'
    ],
    [
        'nombre' => 'Codo PVC 90° 1/2 pulgada',
        'descripcion' => 'Codo de PVC de 90 grados para tubo de 1/2 pulgada, conexión perfecta.',
        'precio' => 2500,
        'stock' => 100,
        'categoria_id' => 2, // Accesorios
        'imagen' => 'codo-pvc-90-1-2.jpg'
    ],
    [
        'nombre' => 'Tee PVC 1/2 pulgada',
        'descripcion' => 'Conexión en T de PVC para tubo de 1/2 pulgada, distribución de agua.',
        'precio' => 3000,
        'stock' => 75,
        'categoria_id' => 2,
        'imagen' => 'tee-pvc-1-2.jpg'
    ],
    [
        'nombre' => 'Cemento PVC 250ml',
        'descripcion' => 'Cemento para PVC, adhesivo de secado rápido para uniones perfectas.',
        'precio' => 8500,
        'stock' => 30,
        'categoria_id' => 3, // Cementos
        'imagen' => 'cemento-pvc-250ml.jpg'
    ],
    [
        'nombre' => 'Cinta Teflón 1/2 pulgada',
        'descripcion' => 'Cinta de teflón de 1/2 pulgada, sellado hermético para conexiones.',
        'precio' => 1500,
        'stock' => 200,
        'categoria_id' => 4, // Sellantes
        'imagen' => 'cinta-teflon-1-2.jpg'
    ],
    [
        'nombre' => 'Válvula PVC 1/2 pulgada',
        'descripcion' => 'Válvula de PVC de 1/2 pulgada, control de flujo de agua.',
        'precio' => 12000,
        'stock' => 20,
        'categoria_id' => 5, // Válvulas
        'imagen' => 'valvula-pvc-1-2.jpg'
    ]
];

// Verificar categorías disponibles
$sql_categorias = "SELECT * FROM categorias ORDER BY id";
$stmt_categorias = $pdo->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Agregar Productos de Ejemplo</h2>";

// Mostrar categorías disponibles
echo "<h3>Categorías disponibles:</h3>";
echo "<ul>";
foreach ($categorias as $categoria) {
    echo "<li>ID: " . $categoria['id'] . " - " . htmlspecialchars($categoria['nombre']) . "</li>";
}
echo "</ul>";

// Agregar productos
$productos_agregados = 0;
foreach ($productos_ejemplo as $producto) {
    try {
        // Verificar si la categoría existe
        $sql_check = "SELECT id FROM categorias WHERE id = :categoria_id";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute(['categoria_id' => $producto['categoria_id']]);
        
        if ($stmt_check->fetch()) {
            $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen, fecha_creacion) 
                    VALUES (:nombre, :descripcion, :precio, :stock, :categoria_id, :imagen, NOW())";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'nombre' => $producto['nombre'],
                'descripcion' => $producto['descripcion'],
                'precio' => $producto['precio'],
                'stock' => $producto['stock'],
                'categoria_id' => $producto['categoria_id'],
                'imagen' => $producto['imagen']
            ]);
            
            echo "<p style='color: green;'>✓ Producto agregado: " . htmlspecialchars($producto['nombre']) . "</p>";
            $productos_agregados++;
        } else {
            echo "<p style='color: red;'>✗ Categoría ID " . $producto['categoria_id'] . " no existe para: " . htmlspecialchars($producto['nombre']) . "</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>✗ Error al agregar " . htmlspecialchars($producto['nombre']) . ": " . $e->getMessage() . "</p>";
    }
}

echo "<h3>Resumen:</h3>";
echo "<p>Productos agregados: " . $productos_agregados . "</p>";
echo "<p><a href='ver_productos_bd.php'>← Ver todos los productos</a></p>";
?> 