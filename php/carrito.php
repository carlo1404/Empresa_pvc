<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

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

$total_items = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total_items += $item['cantidad'];
}

echo json_encode(['ok' => true, 'total_items' => $total_items]);
