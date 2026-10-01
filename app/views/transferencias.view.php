
<?php

session_start();

require '../../vendor/autoload.php';

use App\Controllers\TransferenciaController;

if (!isset($_SESSION['usuario'])) {
    header('Location: /login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$usuarioId = $usuario['id'];

$controller = new TransferenciaController();

$transferencias = $controller->historial($usuarioId);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Banco ADSO - Historial de Transferencias</title>
</head>
<body>

    <h3>Historial de Transferencias</h3>

    <?php if (empty($transferencias)): ?>

        <p>No tienes transferencias registradas.</p>

    <?php else: ?>

        <table border="1">

            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Fecha</th>
            </tr>

            <?php foreach ($transferencias as $transferencia): ?>

                <tr>

                    <td>
                        <?php echo $transferencia['id']; ?>
                    </td>

                    <td>
                        <?php
                        if ($transferencia['usuario_origen_id'] == $usuarioId) {
                            echo "Enviada";
                        } else {
                            echo "Recibida";
                        }
                        ?>
                    </td>

                    <td>
                        $<?php echo $transferencia['valor']; ?>
                    </td>

                    <td>
                        <?php echo $transferencia['fecha']; ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </table>

    <?php endif; ?>

    <br>

    <a href="/app/views/dashboard.view.php">
        Volver al Dashboard
    </a>

</body>
</html>

