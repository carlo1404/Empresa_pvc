<?php
// conexion.php
$host   = 'localhost';
$port   = 3306;
$db     = 'pvc';
$user   = 'root';      // reemplaza con tu usuario
$pass   = '';   // reemplaza con tu contraseña
$charset= 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die('Conexión fallida: ' . $e->getMessage());
}
