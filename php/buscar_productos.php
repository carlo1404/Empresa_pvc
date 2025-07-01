<?php
include '../conexion.php';

$busqueda = $_GET['q'] ?? '';

// Base de la consulta
$sql = "SELECT productos.*, categorias.nombre AS nombre_categoria 
        FROM productos 
        INNER JOIN categorias ON productos.categoria_id = categorias.id";

// Si hay búsqueda, agregamos el filtro
if (!empty($busqueda)) {
    $sql .= " WHERE productos.nombre LIKE :busqueda OR categorias.nombre LIKE :busqueda";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['busqueda' => '%' . $busqueda . '%']);
} else {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verificamos si hay resultados
if (empty($productos)) {
    echo '
    <div id="no-result" class="no-result">
        <img src="img/error.png" alt="Sin resultados">
        <p>Sin resultados<br>No se encontraron productos</p>
    </div>';
    exit; // Opcional: salir para no imprimir más contenido
}

// Generar HTML de productos si hay resultados
foreach ($productos as $producto) {
    echo '
    <div class="productoss__cards">
        <img src="uploads/' . htmlspecialchars($producto['imagen']) . '" alt="Producto" class="productoss__imagen">
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

        <p class="productoss__precio">COP $' . number_format($producto['precio'], 0, ',', '.') . '</p>

        <div class="productoss__acciones">
            <label for="cantidad_' . $producto['id'] . '">Cantidad:</label>
            <input type="number" id="cantidad_' . $producto['id'] . '" name="cantidad_' . $producto['id'] . '" min="1" max="' . $producto['stock'] . '" value="1">

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
