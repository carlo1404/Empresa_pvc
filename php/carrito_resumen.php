<?php
session_start();
header('Content-Type: application/json');

$items = [];
if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $id => $item) {
        $items[] = [
            'id' => $id,
            'nombre' => $item['nombre'],
            'cantidad' => $item['cantidad'],
            'precio' => $item['precio']
        ];
    }
}

echo json_encode(['items' => $items]); 