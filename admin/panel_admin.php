<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="../frontend/admin/admin.css" />
  <link rel="stylesheet" href="../frontend/component/variables.css" />

  <!-- Iconos -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

  <!-- Fuentes -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Gidole&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <title>Panel de Administración</title>
</head>
<body>
  <div class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
      <h2>Panel Admin</h2>
      <ul>
        <li><a href="Gestion/gestion_productos.php"><i class='bx bx-box'></i> Productos</a></li>
        <li><a href="Gestion/producto_mas_vendido.php"><i class='bx bx-bar-chart-alt-2'></i> Más Vendido</a></li>
        <li><a href="categorias/gestion_categorias.php"><i class='bx bx-category'></i> Categorías</a></li>
        <li><a href="Gestion/gestion_usuarios.php"><i class='bx bx-user'></i> Usuarios</a></li>
        <li><a href="Gestion/realizar_pedidos.php"><i class='bx bx-cart'></i> Pedidos</a></li>
        <li><a href="Gestion/gestion_descuentos.php"><i class='bx bx-tag'></i> Descuentos</a></li>
        <li><a href="panel_admin.php"><i class='bx bx-tachometer'></i>Estadisticas</a></li>
        <li><a href="../index.php"><i class='bx bx-home'></i> Inicio</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
      <div class="admin-quick">
        <a href="Gestion/gestion_productos.php"><i class='bx bx-box'></i><span>Productos</span></a>
        <a href="Gestion/producto_mas_vendido.php"><i class='bx bx-bar-chart-alt-2'></i><span>Más Vendido</span></a>
        <a href="categorias/gestion_categorias.php"><i class='bx bx-category'></i><span>Categorías</span></a>
        <a href="Gestion/gestion_usuarios.php"><i class='bx bx-user'></i><span>Usuarios</span></a>
        <a href="Gestion/realizar_pedidos.php"><i class='bx bx-cart'></i><span>Pedidos</span></a>
        <a href="Gestion/gestion_descuentos.php"><i class='bx bx-tag'></i><span>Descuentos</span></a>
        <a href="panel_admin.php"><i class='bx bx-tachometer'></i>Estadisticas</a>
      </div>

      <div class="dashboard-content">
        <h3>Bienvenido al panel</h3>
        <p>Querido administador seleccione uno de los campos para realizar alguna gestion conforme al tema a relizar.</p>
      </div>

      <!-- Gráficas -->
      <div class="charts-container">
        <div class="chart-card">
          <canvas id="gananciaChart"></canvas>
        </div>
        <div class="chart-card">
          <canvas id="inversionChart"></canvas>
        </div>
        <div class="chart-card">
          <canvas id="totalProductosChart"></canvas>
        </div>
        <div class="chart-card">
          <canvas id="posiblesChart"></canvas>
        </div>
      </div>
    </main>
  </div>

  <!-- Librería Chart.js + Script de gráficas -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="../frontend/js/graficas.js"></script>
</body>
</html>
