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

if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
} else {
    $_SESSION['carrito'][$id] = [
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    ];
}

// Calcular total
$total_items = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total_items += $item['cantidad'];
}

// Respuesta rápida
echo json_encode(['ok' => true, 'total_items' => $total_items]);
