<?php

session_start();

require 'vendor/autoload.php';

use App\Controllers\LoginController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $numeroCuenta = $_POST['numero_cuenta'];
    $password = $_POST['password'];

    $controller = new LoginController();

    $usuario = $controller->login($numeroCuenta, $password);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario;
        header('Location: /app/views/dashboard.view.php');
        exit;
    }

    echo "Número de cuenta o contraseña incorrectos.";
    exit;
}

require 'app/views/login.view.php';
