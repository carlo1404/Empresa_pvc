<?php
require_once '../vendor/autoload.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$oauth_config = require __DIR__ . '/config_oauth.php';

$client = new Google_Client();
$client->setClientId($oauth_config['client_id']);
$client->setClientSecret($oauth_config['client_secret']);
$client->setRedirectUri('http://localhost/pvc_project/php/google_oauth.php');
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (isset($token['error'])) {
        echo "Error al obtener el token: " . htmlspecialchars($token['error_description']);
        exit();
    }

    $client->setAccessToken($token);

    $oauth2 = new Google_Service_Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    $_SESSION['usuario'] = [
        'email' => $userInfo->email,
        'name' => $userInfo->name,
        'role' => 'user'
    ];

    setcookie(
        'google_auth',
        json_encode([
            'email' => $userInfo->email,
            'name' => $userInfo->name
        ]),
        time() + (86400 * 30),
        "/"
    );

    header('Location: ../index.php');
    exit();

} else {
    $authUrl = $client->createAuthUrl();
    header("Location: $authUrl");
    exit();
} 