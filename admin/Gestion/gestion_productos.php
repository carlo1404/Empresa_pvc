<?php
require_once '../../conexion.php'; // Conexión PDO

// Consulta con PDO para obtener todos los productos con su categoría
$sql = "SELECT p.*, c.nombre AS categoria_nombre 
        FROM productos p
        LEFT JOIN categorias c ON p.categoria_id = c.id";
$stmt = $pdo->query($sql);
$productos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../..//frontend/admin/panel_admin.css" />
    <link rel="stylesheet" href="../..//frontend/admin/admin.css" />
    <link rel="stylesheet" href="../../frontend/component/main.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Gidole&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <title>Gestión de Productos</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
  <script src="../../frontend/js/reporte.js"></script>

</head>
<body>
  <div class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
      <h2>Panel Admin</h2>
      <ul>
        <li><a href="gestion_productos.php"><i class='bx bx-box'></i> Productos</a></li>
        <li><a href="producto_mas_vendido.php"><i class='bx bx-bar-chart-alt-2'></i> Más Vendido</a></li>
        <li><a href="gestion_categorias.php"><i class='bx bx-category'></i> Categorías</a></li>
        <li><a href="gestion_usuarios.php"><i class='bx bx-user'></i> Usuarios</a></li>
        <li><a href="realizar_pedidos.php"><i class='bx bx-cart'></i> Pedidos</a></li>
        <li><a href="gestion_descuentos.php"><i class='bx bx-tag'></i> Descuentos</a></li>
        <li><a href="../panel_admin.php"><i class='bx bx-tachometer'></i>Estadisticas</a></li>
        <li><a href="../../index.php"><i class='bx bx-home'></i> Inicio</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
      <div class="admin-quick">
        <a href="gestion_productos.php"><i class='bx bx-box'></i><span>Productos</span></a>
        <a href="producto_mas_vendido.php"><i class='bx bx-bar-chart-alt-2'></i><span>Más Vendido</span></a>
        <a href="gestion_categorias.php"><i class='bx bx-category'></i><span>Categorías</span></a>
        <a href="gestion_usuarios.php"><i class='bx bx-user'></i><span>Usuarios</span></a>
        <a href="realizar_pedidos.php"><i class='bx bx-cart'></i><span>Pedidos</span></a>
        <a href="gestion_descuentos.php"><i class='bx bx-tag'></i><span>Descuentos</span></a>
        <a href="../panel_admin.php"><i class='bx bx-tachometer'></i>Estadisticas</a>
      </div>

      <!-- Bienvenida y botón Crear -->
      <div class="dashboard-content">
        <div>
            <h3>Bienvenido al panel de Gestión de productos</h3>
            <p>Aquí puedes gestionar todos los productos registrados en la tienda.</p>
      </div>

  <!-- Contenedor para los botones -->
      <div class="botones-superiores">
          <a href="#" class="btn-descargar-reporte">
            <i class='bx bx-download'></i>
            <span>Descargar Reporte</span>
          </a>

          <a href="crear_producto.php" class="btn-crear-producto">
            <i class='bx bx-plus'></i>
            <span>Crear Producto</span>
          </a>
      </div>
</div>

      <!-- Mostrar productos -->
      <div class="productos-admin-grid">
        <?php foreach ($productos as $producto) : ?>
        <div class="admin-producto-card">
            <?php if (!empty($producto['imagen'])) : ?>
                <img src="../../uploads/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="admin-producto-img">
                        <?php else : ?>
                                <img src="../../uploads/" alt="Imagen predeterminada" class="admin-producto-img">
                                <?php endif; ?>
            <h4><?= htmlspecialchars($producto['nombre']) ?></h4>
            <p><strong>Categoría:</strong> <?= htmlspecialchars($producto['categoria_nombre']) ?></p>
            <p><strong>Descripción:</strong> <?= htmlspecialchars($producto['descripcion']) ?></p>
            <p><strong>Precio:</strong> COP $<?= number_format($producto['precio'], 2) ?></p>
            <p><strong>Stock:</strong> <?= $producto['stock'] ?></p>
            <p><strong>Fecha creación:</strong> <?= $producto['fecha_creacion'] ?></p>
            <div class="acciones-producto">
                <a href="editar_producto.php?id=<?= $producto['id'] ?>" class="btn-editar">Editar</a>
                <a href="eliminar_producto.php?id=<?= $producto['id'] ?>" class="btn-eliminar">Eliminar</a>
            </div>
        </div>
        <?php endforeach; ?>
      </div>
    </main>
  </div>
</body>
</html>
