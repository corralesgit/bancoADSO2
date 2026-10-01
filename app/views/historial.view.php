<?php

session_start();

require '../../vendor/autoload.php';

use App\Controllers\RetiroController;

if (!isset($_SESSION['usuario'])) {
    header('Location: /login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$usuarioId = $usuario['id'];

$controller = new RetiroController();

$retiros = $controller->historial($usuarioId);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Banco ADSO - Historial de Retiros</title>
</head>
<body>

    <h3>Historial de Retiros</h3>

    <?php if (empty($retiros)): ?>

        <p>No tienes retiros registrados.</p>

    <?php else: ?>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Valor</th>
            </tr>

            <?php foreach ($retiros as $retiro): ?>

                <tr>
                    <td><?php echo $retiro['id']; ?></td>
                    <td>$<?php echo $retiro['valor']; ?></td>
                </tr>

            <?php endforeach; ?>

        </table>

    <?php endif; ?>

    <br>

    <a href="/app/views/dashboard.view.php">Volver al Dashboard</a>

</body>
</html>
