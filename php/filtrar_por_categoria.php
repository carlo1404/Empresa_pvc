<?php
include '../conexion.php';

$categoria_id = $_GET['categoria_id'] ?? 'todas';

// Debug: Mostrar qué categoría se está filtrando
error_log("Filtrando categoría: " . $categoria_id);

// Base de la consulta - solo productos que realmente existen
$sql = "SELECT productos.*, categorias.nombre AS nombre_categoria 
        FROM productos 
        INNER JOIN categorias ON productos.categoria_id = categorias.id 
        WHERE productos.id > 0"; // Asegurar que solo productos válidos

// Si hay filtro de categoría específica
if ($categoria_id !== 'todas') {
    $sql .= " AND productos.categoria_id = :categoria_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['categoria_id' => $categoria_id]);
} else {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debug: Mostrar cuántos productos se encontraron
error_log("Productos encontrados: " . count($productos));

// Verificamos si hay resultados
if (empty($productos)) {
    echo '
    <div id="no-result" class="no-result">
        <img src="../img/imagen3.jpg" alt="Sin resultados">
        <p>Sin resultados<br>No se encontraron productos en esta categoría</p>
    </div>';
    exit;
}

// Función para verificar si una imagen existe en uploads
function imagenExiste($ruta_imagen) {
    return file_exists($ruta_imagen);
}

// Generar HTML de productos si hay resultados
foreach ($productos as $producto) {
    // Verificar imagen en carpeta uploads
    $ruta_imagen = "../uploads/" . $producto['imagen'];
    $imagen_src = imagenExiste($ruta_imagen) ? "../uploads/" . $producto['imagen'] : "../img/imagen3.jpg";
    
    echo '
    <div class="productoss__cards" data-categoria="' . htmlspecialchars($producto['nombre_categoria']) . '">
        <img src="' . $imagen_src . '" alt="' . htmlspecialchars($producto['nombre']) . '" class="productoss__imagen" onerror="this.src=\'../img/imagen3.jpg\'">
        <h3 class="productoss__nombre">' . htmlspecialchars($producto['nombre']) . '</h3>
        <p class="productoss__categoria">Categoría: ' . htmlspecialchars($producto['nombre_categoria']) . '</p>
        <p class="productoss__descripcion">' . htmlspecialchars($producto['descripcion']) . '</p>

        <div class="calificar_estrellas" data-rating="0">
            <i class="bx bx-star" data-value="1"></i>
            <i class="bx bx-star" data-value="2"></i>
            <i class="bx bx-star" data-value="3"></i>
            <i class="bx bx-star" data-value="4"></i>
            <i class="bx bx-star" data-value="5"></i>
        </div>

        <div class="productoss__info-row">
            <span class="productoss__precio" data-precio="' . $producto['precio'] . '">COP $' . number_format($producto['precio'], 0, ',', '.') . '</span>
            <span class="productoss__stock' . ($producto['stock'] <= 3 ? ' stock-bajo' : '') . '">Stock: ' . $producto['stock'] . ' disponible' . ($producto['stock'] == 1 ? '' : 's') . '</span>
        </div>

        <div class="productoss__acciones">
            <label for="cantidad_' . $producto['id'] . '">Cantidad:</label>
            <input type="number"
                    id="cantidad_' . $producto['id'] . '"
                    name="cantidad_' . $producto['id'] . '"
                    min="1"
                    max="' . $producto['stock'] . '"
                    value="1">

            <button class="productoss_btn-carrito"
                    data-id="' . $producto['id'] . '"
                    data-nombre="' . htmlspecialchars($producto['nombre']) . '"
                    data-precio="' . $producto['precio'] . '">
                <i class="bx bxs-cart"></i>
                <span>Añadir al carrito</span>
            </button>

            <a href="/php/ver_mas.php?id=' . $producto['id'] . '" class="productoss__btn-vermas">Ver más</a>
        </div>
    </div>';
}
?> 