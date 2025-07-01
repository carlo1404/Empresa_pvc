<?php
// Incluir la conexión
include '../../conexion.php'; // ajusta la ruta según tu estructura

// Verificar si se recibió un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Preparar y ejecutar la consulta con PDO
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirigir después de eliminar
        header("Location: gestion_productos.php?mensaje=eliminado");
        exit();
    } catch (PDOException $e) {
        echo "Error al eliminar el producto: " . $e->getMessage();
    }
} else {
    echo "ID de producto no válido.";
}
