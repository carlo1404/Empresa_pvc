<?php
session_start();
// Capturamos el mensaje de error, si existe, y luego lo limpiamos
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inicio de sesión</title>
  <link rel="stylesheet" href="../frontend/component/main.css" />
  <link rel="stylesheet" href="../frontend/login.css" />
  <!-- Boxicons para los iconos dentro de los inputs -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="../frontend/js/login.js"></script>
</head>
<body>
  <div class="form-container">
    <p class="title">Inicio de sesión</p>

    <!-- Si hay un error, lo mostramos aquí -->
    <?php if ($error): ?>
      <div class="error-message" style="margin-bottom: 1.5rem; text-align: center;">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form class="form" action="database/login_validacion.php" method="post">
      <!-- Grupo: Correo -->
      <div class="input-group">
        <label for="username">Correo</label>
        <div class="input-wrapper">
          <input
            type="email"
            name="email"
            id="username"
            placeholder="Correo"
            required
          />
          <!-- Icono de correo -->
          <i class="bx bx-envelope input-icon"></i>
        </div>
      </div>

      <!-- Grupo: Contraseña -->
      <div class="input-group">
        <label for="password">Contraseña</label>
        <div class="input-wrapper">
          <input
            type="password"
            name="password"
            id="password"
            placeholder="Contraseña"
            minlength="6"
            maxlength="12"
            required
          />
          <!-- Icono de candado -->
          <i class="bx bx-lock-alt input-icon"></i>
        </div>
        <div class="forgot">
          <a href="#">Olvidó su contraseña?</a>
        </div>
      </div>

      <!-- Botón: Iniciar sesión -->
      <button type="submit" class="sign">Iniciar sesión</button>
    </form>

    <!-- Separador y mensaje social -->
    <div class="social-message">
      <div class="line"></div>
      <p class="message">Inicia sesión con tu cuenta social</p>
      <div class="line"></div>
    </div>

    <!-- Íconos sociales -->
    <div class="social-icons">
    <a href="google_oauth.php" aria-label="Log in with Google" class="icon">
    <!-- SVG original de Google -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="w-5 h-5 fill-current">
      <path d="M16.318 13.714v5.484h9.078c-0.37 2.354-2.745 6.901-9.078 6.901-5.458 0-9.917-4.521-9.917-10.099s4.458-10.099 9.917-10.099c3.109 0 5.193 1.318 6.38 2.464l4.339-4.182c-2.786-2.599-6.396-4.182-10.719-4.182-8.844 0-16 7.151-16 16s7.156 16 16 16c9.234 0 15.365-6.49 15.365-15.635 0-1.052-0.115-1.854-0.255-2.651z"></path>
    </svg>
  </a>
    </div>
    <!-- Enlace de registro -->
    <p class="signup">
      No tienes una cuenta? <a href="register.php">Únete</a>
    </p>
  </div>
</body>
</html>
