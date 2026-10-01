<?php

session_start();

require 'vendor/autoload.php';

use App\Controllers\RetiroController;

if (!isset($_SESSION['usuario'])) {
    header('Location: /login.php');
    exit;
}

if (!isset($_POST['valor'])) {
    header('Location: /app/views/retiro.view.php?error=datos_faltantes');
    exit;
}

$valor = $_POST['valor'];
$usuarioId = $_SESSION['usuario']['id'];

$controller = new RetiroController();

$resultado = $controller->realizar($usuarioId, $valor);

if ($resultado === 'ok') {
    $database = new App\Config\Database();
    $pdo = $database->connect();

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $usuarioId]);

    $_SESSION['usuario'] = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Location: /app/views/retiro.view.php?ok=1');
    exit;
}

header('Location: /app/views/retiro.view.php?error=' . $resultado);
exit;