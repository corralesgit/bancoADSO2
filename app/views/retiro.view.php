<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: /login.php');
    exit;
}

$usuario = $_SESSION['usuario'];

if (isset($_GET['error'])) {

    if ($_GET['error'] === 'saldo') {
        echo "<p>No tienes saldo suficiente para realizar este retiro.</p>";
    }

    if ($_GET['error'] === 'valor_invalido') {
        echo "<p>El valor del retiro no es válido.</p>";
    }

    if ($_GET['error'] === 'datos_faltantes') {
        echo "<p>Debes ingresar un valor.</p>";
    }
}

if (isset($_GET['ok'])) {
    echo "<p>Retiro realizado correctamente.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Banco ADSO - Retiro</title>
</head>
<body>

    <h3>Retiro</h3>

    <p>Saldo disponible: $<?php echo $usuario['saldo']; ?></p>

    <form action="/procesar_retiro.php" method="POST">

        <input
            type="number"
            name="valor"
            placeholder="Valor que voy a retirar"
            required
        >

        <br><br>

        <button type="submit">Retirar</button>

    </form>

    <br>

    <a href="/app/views/dashboard.view.php">Volver al Dashboard</a>

</body>
</html>