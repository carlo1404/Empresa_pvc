<?php
session_start();
require_once '../../conexion.php'; // Aquí ya se crea $pdo (PDO object)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogemos los datos del formulario
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validamos que no estén vacíos
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = 'Por favor, completa todos los campos.';
        header('Location: ../../login.php');
        exit();
    }

    // Preparamos la consulta con PDO
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    // Verificamos si el usuario existe
    if (!$usuario) {
        $_SESSION['login_error'] = 'Correo no registrado.';
        header('Location: ../../login.php');
        exit();
    }

    // Verificamos la contraseña
    if (!password_verify($password, $usuario['contrasena'])) {
        $_SESSION['login_error'] = 'Contraseña incorrecta.';
        header('Location: ../../login.php');
        exit();
    }

    // Si todo es correcto, guardamos los datos del usuario
    $userData = [
        'id'         => $usuario['id'],
        'email'      => $usuario['correo'],
        'name'       => $usuario['nombre_completo'],
        'role'       => $usuario['rol'],
        'auth_type'  => 'normal'
    ];

    $_SESSION['usuario'] = $userData;

    // Creamos una cookie con los datos del usuario
    setcookie(
        'auth_user',
        json_encode($userData),
        [
            'expires' => time() + (30 * 24 * 60 * 60), // 30 días
            'path' => '/',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax'
        ]
    );

    // Redirigimos al index
    header('Location: ../../index.php');
    exit();
}
?>
