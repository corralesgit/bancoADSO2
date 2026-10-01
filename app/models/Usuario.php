<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Usuario
{
    private $db;

    public function __construct()
    {
       $database = new Database();
       $this->db = $database->connect();
    }
 
    public function buscarPorCuenta($numeroCuenta)
    {
       $sql = "SELECT * FROM usuarios WHERE numero_cuenta = :numero_cuenta";

       $stmt = $this->db->prepare($sql);
       $stmt->execute([
            ':numero_cuenta' => $numeroCuenta
            ]);
       return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
