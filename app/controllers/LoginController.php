<?php

namespace App\Controllers;

use App\Models\Usuario;

class LoginController
{
    private $usuario;
    
    public function __construct()
    {
      $this->usuario = new Usuario();
    }

    public function login($numeroCuenta, $password)
    {
       $usuario = $this->usuario->buscarPorCuenta($numeroCuenta);

       if (!$usuario) {
           return false;
        }
       if ($usuario['password'] !== $password) {
           return false;
        }

       return $usuario;
     }
}
