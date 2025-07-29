<?php
require_once '../../conexion.php';

// Obtener categorías actuales - ordenadas por ID en lugar de nombre
$query = "SELECT * FROM categorias ORDER BY id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$categorias = $stmt->fetchAll();

// Procesar mensajes de notificación
$mensaje = '';
$tipo_mensaje = '';

if (isset($_GET['mensaje'])) {
    switch ($_GET['mensaje']) {
        case 'categoria_agregada':
            $mensaje = 'Categoría agregada exitosamente.';
            $tipo_mensaje = 'exito';
            break;
        case 'categoria_editada':
            $mensaje = 'Categoría editada exitosamente.';
            $tipo_mensaje = 'exito';
            break;
        case 'categoria_eliminada':
            $mensaje = 'Categoría eliminada exitosamente.';
            $tipo_mensaje = 'exito';
            break;
    }
}

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'nombre_vacio':
            $mensaje = 'El nombre de la categoría no puede estar vacío.';
            $tipo_mensaje = 'error';
            break;
        case 'nombre_duplicado':
            $mensaje = 'Ya existe una categoría con ese nombre.';
            $tipo_mensaje = 'error';
            break;
        case 'categoria_con_productos':
            $mensaje = 'No se puede eliminar una categoría que tiene productos asociados.';
            $tipo_mensaje = 'error';
            break;
        case 'categoria_no_encontrada':
            $mensaje = 'La categoría no fue encontrada.';
            $tipo_mensaje = 'error';
            break;
        case 'error_bd':
            $mensaje = 'Error en la base de datos.';
            $tipo_mensaje = 'error';
            break;
    }
}

?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Carlos Reyes">
    
    <!-- Estilos personalizados -->
    <link rel = "stylesheet" href= "../../frontend/component/main.css" />
    <link rel="stylesheet" href="../../frontend/admin/panel_admin.css" />
    <link rel="stylesheet" href="../../frontend/admin/admin.css" />
    <link rel="stylesheet" href="../../frontend/admin/categorias_admin.css" />

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
        <?php include '../components/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="admin-main">
        <?php include '../components/quick_cards.php'; ?>

        <div class="dashboard-content">
            <h3>Gestión de Categorías</h3>
            <p>Administra las categorías de productos disponibles en el sistema.</p>
        </div>

        <!-- Notificación -->
        <?php if (!empty($mensaje)): ?>
            <div class="notificacion notificacion-<?php echo $tipo_mensaje; ?>">
                <span><?php echo htmlspecialchars($mensaje); ?></span>
                <button onclick="this.parentElement.remove()" class="cerrar-notificacion">
                    <i class='bx bx-x'></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Sección de categorías -->
        <section class="categorias-admin-grid">
            <div class="categorias-container">
                <div class="categorias-header">
                    <h2 class="categorias-title">Categorías Actuales</h2>
                    <button class="btn-agregar" onclick="mostrarFormulario()">
                        <i class='bx bx-plus'></i> Agregar Categoría
                    </button>
                </div>

                <!-- Tabla de categorías -->
                <div class="tabla-categorias">
                    <table class="categorias-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($categorias)): ?>
                                <tr>
                                    <td colspan="3" class="no-categorias">No hay categorías disponibles</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($categorias as $categoria): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                                        <td><?php echo htmlspecialchars($categoria['nombre']); ?></td>
                                        <td class="acciones">
                                            <button class="btn-editar" onclick="editarCategoria(<?php echo $categoria['id']; ?>, '<?php echo htmlspecialchars($categoria['nombre']); ?>')">
                                                <i class='bx bx-edit'></i>
                                            </button>
                                            <button class="btn-eliminar" onclick="eliminarCategoria(<?php echo $categoria['id']; ?>)">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Formulario para agregar/editar categoría -->
                <div id="formulario-categoria" class="formulario-categoria" style="display: none;">
                    <div class="formulario-overlay">
                        <div class="formulario-content">
                            <h3 id="formulario-titulo">Agregar Nueva Categoría</h3>
                            <form id="categoria-form" method="POST" action="procesar_categoria.php">
                                <input type="hidden" id="categoria-id" name="id" value="">
                                <div class="form-group">
                                    <label for="nombre-categoria">Nombre de la Categoría:</label>
                                    <input type="text" id="nombre-categoria" name="nombre" required>
                                </div>
                                <div class="form-buttons">
                                    <button type="submit" class="btn-guardar">
                                        <i class='bx bx-save'></i> Guardar
                                    </button>
                                    <button type="button" class="btn-cancelar" onclick="ocultarFormulario()">
                                        <i class='bx bx-x'></i> Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    </div>

    <script>
        function mostrarFormulario() {
            document.getElementById('formulario-categoria').style.display = 'block';
            document.getElementById('formulario-titulo').textContent = 'Agregar Nueva Categoría';
            document.getElementById('categoria-id').value = '';
            document.getElementById('nombre-categoria').value = '';
        }

        function ocultarFormulario() {
            document.getElementById('formulario-categoria').style.display = 'none';
        }

        function editarCategoria(id, nombre) {
            document.getElementById('formulario-categoria').style.display = 'block';
            document.getElementById('formulario-titulo').textContent = 'Editar Categoría';
            document.getElementById('categoria-id').value = id;
            document.getElementById('nombre-categoria').value = nombre;
        }

        function eliminarCategoria(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta categoría?')) {
                window.location.href = `eliminar_categoria.php?id=${id}`;
            }
        }

        // Auto-ocultar notificaciones después de 5 segundos
        setTimeout(function() {
            const notificaciones = document.querySelectorAll('.notificacion');
            notificaciones.forEach(function(notificacion) {
                notificacion.style.opacity = '0';
                setTimeout(function() {
                    notificacion.remove();
                }, 300);
            });
        }, 5000);
    </script>
    </body>
    </html>
