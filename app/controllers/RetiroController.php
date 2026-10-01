<?php

namespace App\Controllers;

use App\Models\Retiro;

class RetiroController
{
    private $retiro;

    public function __construct()
    {
        $this->retiro = new Retiro();
    }

    public function realizar($usuarioId, $valor)
    {
        if ($valor <= 0) {
            return 'valor_invalido';
        }

        $resultado = $this->retiro->realizar($usuarioId, $valor);

        if (!$resultado) {
            return 'saldo';
        }

        return 'ok';
      }

    public function historial($usuarioId)
    {
        return $this->retiro->listarPorUsuario($usuarioId);
    }
}
