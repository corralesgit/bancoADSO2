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
    <title>Transferencia - Banco ADSO</title>
</head>

<body>

    <h1>Banco ADSO</h1>

    <h2>Transferir Dinero</h2>

    <?php

    if (isset($_GET['error'])) {

        if ($_GET['error'] === 'saldo') {
            echo "<p>No tienes saldo suficiente para realizar esta transferencia.</p>";
        }

        if ($_GET['error'] === 'cuenta_invalida') {
            echo "<p>La cuenta destino no es válida.</p>";
        }

        if ($_GET['error'] === 'no_existe') {
            echo "<p>La cuenta destino no existe.</p>";
        }

        if ($_GET['error'] === 'misma_cuenta') {
            echo "<p>No puedes transferir dinero a tu propia cuenta.</p>";
        }

        if ($_GET['error'] === 'valor_invalido') {
            echo "<p>El valor de la transferencia no es válido.</p>";
        }

        if ($_GET['error'] === 'datos_faltantes') {
            echo "<p>Debes ingresar la cuenta destino y el valor.</p>";
        }
    }

    ?>

    <p>
        Tu cuenta:
        <?php echo $usuario['numero_cuenta']; ?>
    </p>

    <p>
        Saldo:
        $<?php echo $usuario['saldo']; ?>
    </p>

    <form action="/procesar_transferencia.php" method="POST">

        <label>Cuenta destino:</label>
        <br>

        <input
            type="text"
            name="cuenta_destino"
            required
        >

        <br><br>

        <label>Valor a transferir:</label>
        <br>

        <input
            type="number"
            name="valor"
            min="1"
            step="0.01"
            required
        >

        <br><br>

        <button type="submit">
            Transferir
        </button>

    </form>

    <br>

    <a href="/app/views/dashboard.view.php">
        Volver al Dashboard
    </a>

</body>

</html>

