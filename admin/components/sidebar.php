<?php
// Determinar la ruta relativa desde el archivo actual
$current_file = $_SERVER['SCRIPT_NAME'];
$is_in_categorias = strpos($current_file, 'categorias') !== false;
$is_in_gestion = strpos($current_file, 'Gestion') !== false;

// Ajustar rutas según la ubicación
$categorias_path = $is_in_categorias ? 'gestion_categorias.php' : '../categorias/gestion_categorias.php';
$gestion_path = $is_in_gestion ? '' : '../Gestion/';
$panel_path = $is_in_categorias ? '../panel_admin.php' : ($is_in_gestion ? '../panel_admin.php' : 'panel_admin.php');
$index_path = $is_in_categorias ? '../../index.php' : ($is_in_gestion ? '../../index.php' : '../index.php');
?>

<aside class="admin-sidebar">
    <h2>Panel Admin</h2>
    <ul>
        <li><a href="<?php echo $gestion_path; ?>gestion_productos.php"><i class='bx bx-box'></i> Productos</a></li>
        <li><a href="<?php echo $gestion_path; ?>producto_mas_vendido.php"><i class='bx bx-bar-chart-alt-2'></i> Más Vendido</a></li>
        <li><a href="<?php echo $categorias_path; ?>"><i class='bx bx-category'></i> Categorías</a></li>
        <li><a href="<?php echo $gestion_path; ?>gestion_usuarios.php"><i class='bx bx-user'></i> Usuarios</a></li>
        <li><a href="<?php echo $gestion_path; ?>realizar_pedidos.php"><i class='bx bx-cart'></i> Pedidos</a></li>
        <li><a href="<?php echo $gestion_path; ?>gestion_descuentos.php"><i class='bx bx-tag'></i> Descuentos</a></li>
        <li><a href="<?php echo $panel_path; ?>"><i class='bx bx-tachometer'></i>Estadisticas</a></li>
        <li><a href="<?php echo $index_path; ?>"><i class='bx bx-home'></i> Inicio</a></li>
    </ul>
</aside> 