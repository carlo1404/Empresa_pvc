<?php
include '../conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // Eliminar el producto
        $query = "DELETE FROM productos WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>Producto eliminado exitosamente.</p>";
        } else {
            echo "<p style='color: red;'>No se encontró el producto.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Error al eliminar: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>No se proporcionó ID de producto.</p>";
}

// Redirigir de vuelta a la lista
echo "<p><a href='ver_productos_bd.php'>← Volver a la lista de productos</a></p>";
?> 