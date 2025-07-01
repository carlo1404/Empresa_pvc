<?php
session_start();

// Eliminar cookie de Google
setcookie('google_auth', '', [
    'expires' => time() - 3600,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);

// Eliminar cookie de autenticación normal
setcookie('auth_user', '', [
    'expires' => time() - 3600,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);

// Eliminar todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Redirigir al inicio
header('Location: /pvc_project/index.php');
exit;
?>