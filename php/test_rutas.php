<?php
// Archivo de prueba para verificar rutas
echo "Ruta actual: " . __DIR__ . "\n";
echo "Ruta a uploads: " . __DIR__ . "/../uploads/\n";
echo "Ruta a img: " . __DIR__ . "/../img/\n";

// Verificar si existe la carpeta uploads
if (is_dir(__DIR__ . "/../uploads/")) {
    echo "✓ Carpeta uploads existe\n";
    $files = scandir(__DIR__ . "/../uploads/");
    echo "Archivos en uploads: " . implode(", ", array_slice($files, 2)) . "\n";
} else {
    echo "✗ Carpeta uploads NO existe\n";
}

// Verificar si existe la carpeta img
if (is_dir(__DIR__ . "/../img/")) {
    echo "✓ Carpeta img existe\n";
    $files = scandir(__DIR__ . "/../img/");
    echo "Archivos en img: " . implode(", ", array_slice($files, 2)) . "\n";
} else {
    echo "✗ Carpeta img NO existe\n";
}
?> 