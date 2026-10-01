<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Retiro
{
   private $db;

   public function __construct()
   {
      $database = new Database();
      $this->db = $database->connect();
   }
   public function realizar($usuarioId, $valor)
   {
       $sql = "UPDATE usuarios
               SET saldo = saldo - :valor
               WHERE id = :usuario_id
               AND saldo >= :valor";
       $stmt = $this->db->prepare($sql);

       $stmt->execute([
            ':valor' => $valor,
            ':usuario_id' => $usuarioId
       ]);

       if ($stmt->rowCount() === 0) {
          return false;
      }

      $sql = "INSERT INTO retiros (usuario_id, valor)
             VALUES (:usuario_id, :valor)";
      $stmt = $this->db->prepare($sql);

      $stmt->execute([
          ':usuario_id' => $usuarioId,
          ':valor' => $valor
      ]);

      return true;
   }
public function listarPorUsuario($usuarioId)
{
    $sql = "SELECT * FROM retiros
            WHERE usuario_id = :usuario_id
            ORDER BY id DESC";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':usuario_id' => $usuarioId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
}
