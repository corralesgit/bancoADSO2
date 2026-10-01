<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: /login.php');
    exit;
}

$usuario = $_SESSION['usuario'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Banco ADSO - Dashboard</title>
</head>
<body>

    <h2>Hola, <?php echo $usuario['nombre']; ?></h2>

    <p>Documento: <?php echo $usuario['documento']; ?></p>

    <p>Número de cuenta: <?php echo $usuario['numero_cuenta']; ?></p>

    <p>Saldo: $<?php echo $usuario['saldo']; ?></p>

    <br>

    <a href="/app/views/retiro.view.php">
        <button>Retiro</button>
    </a>

    <a href="/app/views/transferencia.view.php">
        <button>Transferencia</button>
    </a>

    <a href="/app/views/historial.view.php">
    <button>Historial de Retiros</button>
   
    </a>

    <a href="/app/views/transferencias.view.php">
    <button>Historial de Transferencias</button>
    
    </a>

    <a href="/logout.php">Cerrar Sesión</a>


</body>
</html>

