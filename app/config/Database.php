<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
  private $host = 'localhost';
  private $dbname = 'banco_adso';
  private $username = 'root';
  private $password = '0000';

  public function connect()
    {
     try {
        $pdo = new PDO(
                  "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                   $this->username,
                   $this->password
                   );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   return $pdo;
         } catch (PDOException $e) {
            die("Error de conexion: " . $e->getMessage());
         }
     }
}
