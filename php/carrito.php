<?php
session_start();
header('Content-Type: application/json');

// Obtener datos de entrada
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validación básica
if (!$data || !isset($data['id']) || !isset($data['nombre']) || !isset($data['precio']) || !isset($data['cantidad'])) {
    echo json_encode(['ok' => false, 'error' => 'Datos incompletos']);
    exit;
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Añadir o actualizar producto
$id = $data['id'];
$nombre = $data['nombre'];
$precio = $data['precio'];
$cantidad = $data['cantidad'];

include '../conexion.php'; // Asegúrate de que la ruta sea correcta

// Consultar stock real
$stmt = $pdo->prepare('SELECT stock FROM productos WHERE id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) {
    echo json_encode(['ok' => false, 'error' => 'Producto no encontrado']);
    exit;
}
$stock = (int)$row['stock'];

$cantidadEnCarrito = isset($_SESSION['carrito'][$id]) ? $_SESSION['carrito'][$id]['cantidad'] : 0;
if ($cantidadEnCarrito + $cantidad > $stock) {
    echo json_encode(['ok' => false, 'error' => 'stock']);
    exit;
}

if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
} else {
    $_SESSION['carrito'][$id] = [
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    ];
}

// Soporte para eliminar producto
if (isset($data['eliminar']) && $data['eliminar'] && isset($id)) {
    unset($_SESSION['carrito'][$id]);
    // Calcular total
    $total_items = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $total_items += $item['cantidad'];
    }
    echo json_encode(['ok' => true, 'total_items' => $total_items]);
    exit;
}
// Soporte para actualizar cantidad
if (isset($data['actualizar']) && $data['actualizar'] && isset($id) && isset($data['cantidad'])) {
    $nuevaCantidad = (int)$data['cantidad'];
    if ($nuevaCantidad < 1) $nuevaCantidad = 1;
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] = $nuevaCantidad;
    }
    // Calcular total
    $total_items = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $total_items += $item['cantidad'];
    }
    echo json_encode(['ok' => true, 'total_items' => $total_items]);
    exit;
}

// Calcular total
$total_items = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total_items += $item['cantidad'];
}

// Respuesta rápida
echo json_encode(['ok' => true, 'total_items' => $total_items]);
