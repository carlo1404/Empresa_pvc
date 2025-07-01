<?php
include '../../conexion.php'; // Asegúrate de que la conexión sea válida

// Verificar que los datos del formulario existan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];

    // Manejar la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // Ruta de la carpeta donde se guardarán las imágenes
        $directorioDestino = '../../uploads/';
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0755, true);
        }

        $nombreImagen = time() . '_' . basename($_FILES['imagen']['name']);
        $rutaCompleta = $directorioDestino . $nombreImagen;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaCompleta)) {
            // Guardar en la base de datos
            $query = "INSERT INTO productos (nombre, stock, descripcion, categoria_id, precio, imagen) 
                    VALUES (:nombre, :stock, :descripcion, :categoria, :precio, :imagen)";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':imagen', $nombreImagen); // Solo se guarda el nombre

            if ($stmt->execute()) {
                header('Location: gestion_productos.php?mensaje=producto_guardado');
                exit();
            } else {
                echo "Error al guardar en la base de datos.";
            }
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "No se ha subido una imagen válida.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
