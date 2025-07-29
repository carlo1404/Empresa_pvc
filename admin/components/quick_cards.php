<?php
// Determinar la ruta relativa desde el archivo actual
$current_file = $_SERVER['SCRIPT_NAME'];
$is_in_categorias = strpos($current_file, 'categorias') !== false;
$is_in_gestion = strpos($current_file, 'Gestion') !== false;

// Ajustar rutas según la ubicación
$categorias_path = $is_in_categorias ? 'gestion_categorias.php' : '../categorias/gestion_categorias.php';
$gestion_path = $is_in_gestion ? '' : '../Gestion/';
$panel_path = $is_in_categorias ? '../panel_admin.php' : ($is_in_gestion ? '../panel_admin.php' : 'panel_admin.php');
?>

<div class="admin-quick">
    <a href="<?php echo $gestion_path; ?>gestion_productos.php"><i class='bx bx-box'></i><span>Productos</span></a>
    <a href="<?php echo $gestion_path; ?>producto_mas_vendido.php"><i class='bx bx-bar-chart-alt-2'></i><span>Más Vendido</span></a>
    <a href="<?php echo $categorias_path; ?>"><i class='bx bx-category'></i><span>Categorías</span></a>
    <a href="<?php echo $gestion_path; ?>gestion_usuarios.php"><i class='bx bx-user'></i><span>Usuarios</span></a>
    <a href="<?php echo $gestion_path; ?>realizar_pedidos.php"><i class='bx bx-cart'></i><span>Pedidos</span></a>
    <a href="<?php echo $gestion_path; ?>gestion_descuentos.php"><i class='bx bx-tag'></i><span>Descuentos</span></a>
    <a href="<?php echo $panel_path; ?>"><i class='bx bx-tachometer'></i>Estadisticas</a>
</div> 