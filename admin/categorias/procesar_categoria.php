<?php
require_once '../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $id = $_POST['id'] ?? null;
    
    // Validar que el nombre no esté vacío
    if (empty($nombre)) {
        header('Location: gestion_categorias.php?error=nombre_vacio');
        exit();
    }
    
    try {
        if (empty($id)) {
            // Agregar nueva categoría
            $query = "INSERT INTO categorias (nombre) VALUES (:nombre)";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['nombre' => $nombre]);
            
            header('Location: gestion_categorias.php?mensaje=categoria_agregada');
        } else {
            // Editar categoría existente
            $query = "UPDATE categorias SET nombre = :nombre WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['nombre' => $nombre, 'id' => $id]);
            
            header('Location: gestion_categorias.php?mensaje=categoria_editada');
        }
    } catch (PDOException $e) {
        // Verificar si es un error de duplicado
        if ($e->getCode() == 23000) {
            header('Location: gestion_categorias.php?error=nombre_duplicado');
        } else {
            header('Location: gestion_categorias.php?error=error_bd');
        }
    }
} else {
    header('Location: gestion_categorias.php');
}
exit();
?> 