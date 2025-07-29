<?php
include '../conexion.php';

// Obtener un producto de prueba
$sql = "SELECT productos.*, categorias.nombre AS nombre_categoria 
        FROM productos 
        INNER JOIN categorias ON productos.categoria_id = categorias.id 
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($producto) {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Test Cards</title>
        <link rel="stylesheet" href="../frontend/index.css">
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="productoss__grid">
            <div class="productoss__cards" data-categoria="' . htmlspecialchars($producto['nombre_categoria']) . '">
                <img src="../uploads/' . htmlspecialchars($producto['imagen']) . '" alt="Producto" class="productoss__imagen">
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
            </div>
        </div>
    </body>
    </html>';
} else {
    echo '<p>No hay productos disponibles para la prueba.</p>';
}
?> 