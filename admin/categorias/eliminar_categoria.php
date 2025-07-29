<?php
require_once '../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // Verificar si la categoría tiene productos asociados
        $query_productos = "SELECT COUNT(*) as total FROM productos WHERE categoria_id = :id";
        $stmt_productos = $pdo->prepare($query_productos);
        $stmt_productos->execute(['id' => $id]);
        $resultado = $stmt_productos->fetch();
        
        if ($resultado['total'] > 0) {
            header('Location: gestion_categorias.php?error=categoria_con_productos');
            exit();
        }
        
        // Eliminar la categoría
        $query = "DELETE FROM categorias WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        
        if ($stmt->rowCount() > 0) {
            header('Location: gestion_categorias.php?mensaje=categoria_eliminada');
        } else {
            header('Location: gestion_categorias.php?error=categoria_no_encontrada');
        }
    } catch (PDOException $e) {
        header('Location: gestion_categorias.php?error=error_bd');
    }
} else {
    header('Location: gestion_categorias.php');
}
exit();
?> 