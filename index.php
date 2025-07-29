<?php
include 'conexion.php'; // Incluir la conexión a la base de datos
// Verifica si el usuario está autenticado

$sql = "SELECT productos.*, categorias.nombre AS nombre_categoria 
        FROM productos 
        INNER JOIN categorias ON productos.categoria_id = categorias.id 
        WHERE productos.id > 0"; // Solo productos válidos

$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="frontend/index.css">
    <link rel="stylesheet" href="frontend/header.css">
    <link rel="stylesheet" href="frontend/component/main.css">
    <link rel="stylesheet" href="frontend/component/carrito-optimizado.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Gidole&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <title>Inicio</title>
    <script defer src="frontend/js/carousel.js"></script>
    <script defer src="frontend/js/calificacion.js"></script>
    <script defer src="frontend/js/productos.js"></script>
    <script defer src="frontend/js/stock.js"></script>
    <script defer src="frontend/js/carrito.js"></script>
    <script defer src="frontend/js/buscador.js"></script>
    <script defer src="frontend/js/categorias.js"></script>
    <!-- <script defer src="frontend/js/menu.js"></script> -->

</head>
<body>
    <?php include 'php/components/header.php'; ?>

    <main class="main">
    <section class="main__hero">
        <div class="carousel">
            <button class="carousel__button carousel__button--left">‹</button>

            <div class="carousel__track-container">
                <div class="carousel__track">
                    <img class="carousel__slide current-slide" src="img/imagen0.jpg" alt="PVC Producto 1">
                    <img class="carousel__slide" src="img/imagen1.jpg" alt="PVC Producto 2">
                    <img class="carousel__slide" src="img/imagen2.jpg" alt="PVC Producto 3">
                    <img class="carousel__slide" src="img/imagen4.jpg" alt="PVC Producto 4">
                    <img class="carousel__slide" src="img/imagen5.jpg" alt="PVC Producto 5">
                    <img class="carousel__slide" src="img/imagen3.jpg" alt="PVC Producto 6">
                </div>
            </div>

            <button class="carousel__button carousel__button--right">›</button>

            <!-- Indicadores opcionales -->
            <div class="carousel__nav">
                <button class="current-slide"></button>
                <button></button>
                <button></button>
                <button></button>
                <button></button>
                <button></button>
            </div>
        </div>
    </section>
</main>
<!-- vamos a poner categorias de pvc ejemplo tubos laminas tornillos puntillas cemento pegatina etc en forma de links de barra pero sin background que quede como un un tr o una linea de bajo -->
<!-- nav categorias -->
<nav class="categorias-nav">
  <ul class="categorias-nav__lista">
    <li><a href="#" class="categoria-link" data-categoria-id="todas">Todas</a></li>
    <?php
    include 'conexion.php'; // Incluir la conexión PDO

    // Consulta SQL
    $query = "SELECT * FROM categorias ORDER BY id";
    
    // Preparar la consulta con PDO
    $stmt = $pdo->prepare($query);
    $stmt->execute(); // Ejecutar la consulta

    // Obtener los resultados
    while ($categoria = $stmt->fetch()) {
        echo '<li><a href="#" class="categoria-link" data-categoria-id="' . $categoria['id'] . '">' . htmlspecialchars($categoria['nombre']) . '</a></li>';
    }
    ?>
  </ul>
</nav>

<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<section class="productos">
  <h2 class="productos__titulo">Nuestros Productos En Descuento</h2>

  <div class="productos__grid">
    <?php
    // Obtener productos con descuento (por ejemplo, los primeros 3 productos válidos)
    $sql_descuento = "SELECT productos.*, categorias.nombre AS nombre_categoria 
                      FROM productos 
                      INNER JOIN categorias ON productos.categoria_id = categorias.id 
                      WHERE productos.id > 0
                      ORDER BY productos.id 
                      LIMIT 3";
    $stmt_descuento = $pdo->prepare($sql_descuento);
    $stmt_descuento->execute();
    $productos_descuento = $stmt_descuento->fetchAll();
    
    if (empty($productos_descuento)) {
        echo '<p style="text-align: center; color: #666; padding: 20px;">No hay productos en descuento disponibles.</p>';
    } else {
        foreach ($productos_descuento as $producto) :
            // Verificar si la imagen existe en uploads
            $ruta_imagen = "uploads/" . $producto['imagen'];
            $imagen_src = file_exists($ruta_imagen) ? $ruta_imagen : "img/imagen3.jpg";
        ?>
        <!-- Card de producto de descuento -->
        <div class="producto__card">
          <div class="descuento-icono">
            <i class='bx bx-purchase-tag'></i>
          </div>

          <img src="<?php echo $imagen_src; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" onerror="this.src='img/imagen3.jpg'">

          <div class="producto__contenido">
            <h2 class="producto__nombre"><?php echo htmlspecialchars($producto['nombre']); ?></h2>
            <p class="producto__descripcion">
              <?php echo htmlspecialchars($producto['descripcion']); ?>
            </p>
            
            <!-- Estrellas interactivas -->
            <div class="estrellas" data-rating="0" aria-label="Calificación del producto">
              <i class='bx bx-star' data-value="1"></i>
              <i class='bx bx-star' data-value="2"></i>
              <i class='bx bx-star' data-value="3"></i>
              <i class='bx bx-star' data-value="4"></i>
              <i class='bx bx-star' data-value="5"></i>
            </div>

            <p class="precio">COP $<?php echo number_format($producto['precio'], 0, ',', '.'); ?></p>

            <!-- Cantidad -->
            <div class="cantidad">
              <label for="cantidad_descuento_<?php echo $producto['id']; ?>">Cantidad:</label>
              <input type="number" id="cantidad_descuento_<?php echo $producto['id']; ?>" name="cantidad_descuento_<?php echo $producto['id']; ?>" min="1" value="1">
            </div>

            <button class="productoss_btn-carrito"
                    data-id="<?php echo $producto['id']; ?>"
                    data-nombre="<?php echo htmlspecialchars($producto['nombre']); ?>"
                    data-precio="<?php echo $producto['precio']; ?>">
              <i class='bx bxs-cart'></i> <span>Añadir al carrito</span>
            </button>
          </div>
        </div>
        <?php 
        endforeach; 
    }
    ?>
  </div>
</section>

<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<section class="productoss">
  <h2 class="productoss__titulo">Todos los Productos</h2>

  <!-- Buscador -->
  <div class="productoss__buscador">
    <div class="productoss__input-container">
      <input
        class="productoss__buscar"
        type="text"
        id="buscador-global"
        placeholder="Buscar productos..."
        oninput="filtrarProductos()" />
      <i class="bx bx-search"></i>
    </div>
  </div>

  <!-- Loader -->
  <div id="loader" class="productoss__loader" style="display: none;">
    <div class="spinner"></div>
  </div>

  <!-- Resultado vacío -->
  <div id="no-result" class="no-result" style="display: none;">
    <img src="img/empty-box.png" alt="Sin resultados" />
    <p>No se encontraron productos</p>
  </div>

  <!-- Productos -->
  <div class="productoss__grid">
    <?php
    if (empty($resultado)) {
        echo '<div class="no-result">
                <img src="img/imagen3.jpg" alt="Sin productos">
                <p>No hay productos disponibles<br>Vuelve más tarde</p>
              </div>';
    } else {
        $producto_descuento_id = 1; // El id del producto en descuento
        foreach ($resultado as $producto) :
          if ($producto['id'] == $producto_descuento_id) continue;
          
          // Verificar si la imagen existe en uploads
          $ruta_imagen = "uploads/" . $producto['imagen'];
          $imagen_src = file_exists($ruta_imagen) ? $ruta_imagen : "img/imagen3.jpg";
        ?>
          <div class="productoss__cards" data-categoria="<?php echo htmlspecialchars($producto['nombre_categoria']); ?>">
            <img src="<?php echo $imagen_src; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="productoss__imagen" onerror="this.src='img/imagen3.jpg'">
            <h3 class="productoss__nombre"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
            <p class="productoss__categoria">Categoría: <?php echo htmlspecialchars($producto['nombre_categoria']); ?></p>
            <p class="productoss__descripcion"><?php echo htmlspecialchars($producto['descripcion']); ?></p>

            <div class="calificar_estrellas" data-rating="0">
              <i class='bx bx-star' data-value="1"></i>
              <i class='bx bx-star' data-value="2"></i>
              <i class='bx bx-star' data-value="3"></i>
              <i class='bx bx-star' data-value="4"></i>
              <i class='bx bx-star' data-value="5"></i>
            </div>

            <div class="productoss__info-row">
              <span class="productoss__precio" data-precio="<?php echo $producto['precio']; ?>">COP $<?php echo number_format($producto['precio'], 0, ',', '.'); ?></span>
              <span class="productoss__stock<?php echo ($producto['stock'] <= 3 ? ' stock-bajo' : ''); ?>">Stock: <?php echo $producto['stock']; ?> disponible<?php echo $producto['stock'] == 1 ? '' : 's'; ?></span>
            </div>

            <div class="productoss__acciones">
              <label for="cantidad_<?php echo $producto['id']; ?>">Cantidad:</label>
              <input type="number"
                      id="cantidad_<?php echo $producto['id']; ?>"
                      name="cantidad_<?php echo $producto['id']; ?>"
                      min="1"
                      max="<?php echo $producto['stock']; ?>"
                      value="1">

              <button class="productoss_btn-carrito"
                      data-id="<?php echo $producto['id']; ?>"
                      data-nombre="<?php echo htmlspecialchars($producto['nombre']); ?>"
                      data-precio="<?php echo $producto['precio']; ?>">
                <i class='bx bxs-cart'></i>
                <span>Añadir al carrito</span>
              </button>

              <a href="/php/ver_mas.php?id=<?php echo $producto['id']; ?>" class="productoss__btn-vermas">Ver más</a>
            </div>
          </div>
        <?php 
        endforeach; 
    }
    ?>
  </div>
</section>


</body>
</html>
