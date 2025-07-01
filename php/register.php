<?php
// register.php (en /php/)
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro</title>
  <link rel="stylesheet" href="../frontend/component/main.css" />
  <link rel="stylesheet" href="../frontend/register.css" />
  <!-- Boxicons -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="../frontend/js/register.js"></script>
</head>
<body>
  <div class="form-container">
    <p class="title">Crear Cuenta</p>

    <form class="form" action="database/register_validacion.php" method="post">
      <!-- Nombre completo -->
      <div class="input-group">
        <label for="fullname">Nombre Completo</label>
        <div class="input-wrapper">
          <input
            type="text"
            id="fullname"
            name="fullname"
            placeholder="Tu nombre completo"
            required
          />
          <i class="bx bx-user input-icon"></i>
        </div>
      </div>

      <!-- Cédula / Identificación -->
      <div class="input-group">
        <label for="idnumber">Cédula / Identificación</label>
        <div class="input-wrapper">
          <input
            type="text"
            id="idnumber"
            name="idnumber"
            placeholder="Número de identificación"
            required
          />
          <i class="bx bx-id-card input-icon"></i>
        </div>
      </div>

      <!-- Correo -->
      <div class="input-group">
        <label for="email">Correo Electrónico</label>
        <div class="input-wrapper">
          <input
            type="email"
            id="email"
            name="email"
            placeholder="ejemplo@correo.com"
            required
          />
          <i class="bx bx-envelope input-icon"></i>
        </div>
      </div>

      <!-- Contraseña -->
      <div class="input-group">
        <label for="password">Contraseña</label>
        <div class="input-wrapper">
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Contraseña"
            minlength="6"
            required
          />
          <i class="bx bx-lock-alt input-icon"></i>
        </div>
      </div>

      <!-- Confirmar contraseña -->
      <div class="input-group">
        <label for="confirm_password">Confirmar Contraseña</label>
        <div class="input-wrapper">
          <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            placeholder="Repite la contraseña"
            minlength="6"
            required
          />
          <i class="bx bx-lock-alt input-icon"></i>
        </div>
      </div>

      <!-- Botón de registro -->
      <button type="submit" class="sign">Registrarse</button>
    </form>

    <!-- “Ya tienes cuenta?” -->
    <p class="signup">
      ¿Ya tienes una cuenta?
      <a href="login.php">Inicia sesión</a>
    </p>

    <!-- Separador social -->
    <div class="social-message">
      <div class="line"></div>
      <p class="message">O registra con</p>
      <div class="line"></div>
    </div>

    <!-- Íconos sociales -->
    <div class="social-icons">
      <button aria-label="Registrarse con Google" class="icon">
        <i class="bx bxl-google"></i>
      </button>
      <button aria-label="Registrarse con Twitter" class="icon">
        <i class="bx bxl-twitter"></i>
      </button>
    </div>
  </div>
</body>
</html>
