<?php

namespace App\Controllers;

use App\Models\Transferencia;

class TransferenciaController
{
    private $transferencia;

    public function __construct()
    {
        $this->transferencia = new Transferencia();
    }

    public function realizar($usuarioOrigenId, $numeroCuentaDestino, $valor)
    {
        if ($valor <= 0) {
            return 'valor_invalido';
        }

        $usuarioDestino = $this->transferencia->buscarUsuarioPorCuenta($numeroCuentaDestino);

        if (!$usuarioDestino) {
            return 'no_existe';
        }

        if ($usuarioDestino['id'] == $usuarioOrigenId) {
            return 'misma_cuenta';
        }

        $resultado = $this->transferencia->realizar(
            $usuarioOrigenId,
            $usuarioDestino['id'],
            $valor
        );

        if (!$resultado) {
            return 'saldo';
        }

        return 'ok';
    }

public function historial($usuarioId)
{
    return $this->transferencia->listarPorUsuario($usuarioId);
    }
}
