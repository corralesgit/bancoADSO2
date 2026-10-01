<?php

session_start();

require 'vendor/autoload.php';

use App\Controllers\TransferenciaController;

if (!isset($_SESSION['usuario'])) {
    header('Location: /login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /app/views/transferencia.view.php');
    exit;
}

if (!isset($_POST['cuenta_destino']) || !isset($_POST['valor'])) {
    header('Location: /app/views/transferencia.view.php?error=datos_faltantes');
    exit;
}

$cuentaDestino = $_POST['cuenta_destino'];
$valor = $_POST['valor'];

if ($cuentaDestino === '' || !ctype_digit($cuentaDestino)) {
    header('Location: /app/views/transferencia.view.php?error=cuenta_invalida');
    exit;
}

if ($valor === '' || !is_numeric($valor) || $valor <= 0) {
    header('Location: /app/views/transferencia.view.php?error=valor_invalido');
    exit;
}

$usuarioOrigenId = $_SESSION['usuario']['id'];

$controller = new TransferenciaController();

$resultado = $controller->realizar(
    $usuarioOrigenId,
    $cuentaDestino,
    $valor
);

if ($resultado === 'ok') {

    $database = new App\Config\Database();
    $pdo = $database->connect();

    $stmt = $pdo->prepare(
        "SELECT * FROM usuarios WHERE id = :id"
    );

    $stmt->execute([
        ':id' => $usuarioOrigenId
    ]);

    $_SESSION['usuario'] = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Location: /app/views/dashboard.view.php?msg=transfer_ok');
    exit;
}

header(
    'Location: /app/views/transferencia.view.php?error=' . $resultado
);
exit;

