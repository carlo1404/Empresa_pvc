<?php
session_start();
include 'php/components/header.php';

$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="frontend/header.css">
    <link rel="stylesheet" href="frontend/index.css">
    <link rel="stylesheet" href="frontend/component/carrito-optimizado.css">
    <style>
        .carrito-container {
            max-width: 900px;
            margin: 3rem auto 2rem auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
            padding: 2.5rem 2rem 2rem 2rem;
        }
        .carrito-titulo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
            color: #1e88e5;
        }
        .carrito-lista {
            width: 100%;
            border-collapse: collapse;
        }
        .carrito-lista th, .carrito-lista td {
            padding: 1rem 0.7rem;
            text-align: center;
        }
        .carrito-lista th {
            background: #f0f0f0;
            font-weight: 600;
            color: #333;
        }
        .carrito-lista tr {
            border-bottom: 1px solid #eee;
        }
        .carrito-lista img {
            width: 60px;
            border-radius: 8px;
        }
        .carrito-acciones {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        .carrito-btn {
            background: #1e88e5;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 0.4rem 1.1rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .carrito-btn:hover {
            background: #1565c0;
        }
        .carrito-btn.eliminar {
            background: #e53935;
        }
        .carrito-btn.eliminar:hover {
            background: #b71c1c;
        }
        .carrito-total {
            text-align: right;
            font-size: 1.3rem;
            font-weight: 600;
            margin-top: 1.5rem;
            color: #222;
        }
        .carrito-vacio {
            text-align: center;
            color: #888;
            font-size: 1.2rem;
            padding: 2rem 0;
        }
        @media (max-width: 700px) {
            .carrito-container { padding: 1rem; }
            .carrito-lista th, .carrito-lista td { padding: 0.5rem 0.2rem; }
        }
    </style>
</head>
<body>
<div class="carrito-container">
    <div class="carrito-titulo">Carrito de compras</div>
    <?php if (empty($carrito)): ?>
        <div class="carrito-vacio">Tu carrito está vacío.</div>
    <?php else: ?>
        <table class="carrito-lista">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrito as $id => $item):
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><img src="uploads/<?php echo htmlspecialchars($item['imagen'] ?? ''); ?>" alt="Producto"></td>
                    <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                    <td>
                        <form method="post" action="ver_carrito.php" style="display:inline;">
                            <input type="hidden" name="update_id" value="<?php echo $id; ?>">
                            <input type="number" name="update_cantidad" value="<?php echo $item['cantidad']; ?>" min="1" style="width:50px;">
                            <button type="submit" class="carrito-btn">Actualizar</button>
                        </form>
                    </td>
                    <td>$<?php echo number_format($item['precio'], 0, ',', '.'); ?></td>
                    <td>$<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    <td class="carrito-acciones">
                        <form method="post" action="ver_carrito.php" style="display:inline;">
                            <input type="hidden" name="eliminar_id" value="<?php echo $id; ?>">
                            <button type="submit" class="carrito-btn eliminar">Eliminar</button>
                        </form>
                        <form method="post" action="pagar.php" style="display:inline;">
                            <input type="hidden" name="pagar_id" value="<?php echo $id; ?>">
                            <button type="submit" class="carrito-btn">Pagar este</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="carrito-total">Total: $<?php echo number_format($total, 0, ',', '.'); ?></div>
        <form method="post" action="pagar.php" style="text-align:right; margin-top:1.5rem;">
            <button type="submit" name="pagar_todo" class="carrito-btn" style="font-size:1.1rem;">Pagar todo</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
<?php
// Lógica para eliminar o actualizar productos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar_id'])) {
        unset($_SESSION['carrito'][$_POST['eliminar_id']]);
        header('Location: ver_carrito.php');
        exit;
    }
    if (isset($_POST['update_id'], $_POST['update_cantidad'])) {
        $id = $_POST['update_id'];
        $cantidad = max(1, intval($_POST['update_cantidad']));
        $_SESSION['carrito'][$id]['cantidad'] = $cantidad;
        header('Location: ver_carrito.php');
        exit;
    }
}
?> 