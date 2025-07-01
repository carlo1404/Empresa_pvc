<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar cookie de autenticación de Google
if (!isset($_SESSION['usuario']) && isset($_COOKIE['google_auth'])) {
    $googleData = json_decode($_COOKIE['google_auth'], true);
    if ($googleData && isset($googleData['email'])) {
        $_SESSION['usuario'] = [
            'name' => $googleData['name'],
            'email' => $googleData['email'],
            'role' => 'user',
            'auth_type' => 'google'
        ];
        // ...existing code for setcookie...
    }
}

// Verificar cookie de autenticación normal
if (!isset($_SESSION['usuario']) && isset($_COOKIE['auth_user'])) {
    $userData = json_decode($_COOKIE['auth_user'], true);
    if ($userData && isset($userData['email'])) {
        $_SESSION['usuario'] = $userData;
        // ...existing code for setcookie...
    }
}

// Inicializar variables necesarias
$isLoggedIn = isset($_SESSION['usuario']); // Define si el usuario está logueado

// Calcular total de items en el carrito
$total_items = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total_items += $item['cantidad'];
    }
}

// Detectar si estamos en ver_carrito.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="header">
  <div class="header__container">
    <!-- Título al centro -->
    <div class="header__title">
      <h1 class="header__title-text">PVC</h1>
    </div>
    <!-- Botón Hamburguesa solo para móviles -->
    <button class="hamburger" id="hamburger-btn" aria-label="Menú">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <!-- Acciones a la derecha (Login/Logout, Carrito, Home) -->
    <div class="header__actions">
      <?php if ($isLoggedIn): ?>
        <!-- Muestra el nombre de usuario y logout -->
        <?php if ($_SESSION['usuario']['role'] === 'admin'): ?>
          <!-- Si es admin, mostrar "Admin" -->
          <span class="header__user">Hola, Admin</span>
          <!-- Enlace al Panel de Administración -->
          <a href="../../pvc_project/admin/panel_admin.php" class="header__action">
            <i class='bx bx-cog'></i>
            <span>Panel de Administración</span>
          </a>
        <?php else: ?>
          <!-- Si es usuario, mostrar el nombre del usuario -->
          <span class="header__user">Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['name']); ?></span>
        <?php endif; ?>
        <a href="php/logout.php" class="header__action">
          <i class='bx bx-log-out'></i>
          <span>Cerrar sesión</span>
        </a>
      <?php else: ?>
        <a href="php/login.php" class="header__action">
          <i class='bx bx-user-circle'></i>
          <span>Iniciar sesión</span>
        </a>
      <?php endif; ?>
      <?php if ($current_page === 'ver_carrito.php'): ?>
        <a href="ver_carrito.php" class="header__action header__cart">
          <i class='bx bx-shopping-bag'></i>
          <span>Carrito</span>
          <span class="cart-badge"><?php echo $total_items; ?></span>
        </a>
      <?php else: ?>
        <a href="ver_carrito.php" class="header__action header__cart" id="cart-dropdown-toggle">
          <i class='bx bx-shopping-bag'></i>
          <span>Carrito</span>
          <span class="cart-badge"><?php echo $total_items; ?></span>
        </a>
        <div id="cart-dropdown" class="cart-dropdown" style="display: none;">
          <div class="cart-dropdown__content">
            <h4>Carrito de compras</h4>
            <div id="cart-items-container">
              <p class="cart-dropdown__empty">Tu carrito está vacío.</p>
            </div>
            <a href="ver_carrito.php" class="cart-dropdown__vermas">Ver carrito completo</a>
          </div>
        </div>
      <?php endif; ?>
      <a href="index.php" class="header__action">
        <i class='bx bxs-home'></i>
        <span>Inicio</span>
      </a>
    </div>
  </div>
  <script src="../pvc_project/frontend/js/menu.js" defer></script>
</header>
