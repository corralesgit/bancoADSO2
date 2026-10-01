<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Transferencia
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function realizar($usuarioOrigenId, $usuarioDestinoId, $valor)
    {
    try {

        $this->db->beginTransaction();

        $sql = "UPDATE usuarios
                SET saldo = saldo - :valor
                WHERE id = :usuario_origen_id
                AND saldo >= :valor";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':valor' => $valor,
            ':usuario_origen_id' => $usuarioOrigenId
        ]);

        if ($stmt->rowCount() === 0) {
            $this->db->rollBack();
            return false;
        }

        $sql = "UPDATE usuarios
                SET saldo = saldo + :valor
                WHERE id = :usuario_destino_id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':valor' => $valor,
            ':usuario_destino_id' => $usuarioDestinoId
        ]);

        if ($stmt->rowCount() === 0) {
            $this->db->rollBack();
            return false;
        }

        $sql = "INSERT INTO transferencias
                (usuario_origen_id, usuario_destino_id, valor)
                VALUES (:usuario_origen_id, :usuario_destino_id, :valor)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':usuario_origen_id' => $usuarioOrigenId,
            ':usuario_destino_id' => $usuarioDestinoId,
            ':valor' => $valor
        ]);

        $this->db->commit();

        return true;

        } catch (\PDOException $e) {

        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }

        return false;
    }
}

    public function buscarUsuarioPorCuenta($numeroCuenta)
    {
        $sql = "SELECT * FROM usuarios
                WHERE numero_cuenta = :numero_cuenta";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':numero_cuenta' => $numeroCuenta
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public function listarPorUsuario($usuarioId)
{
    $sql = "SELECT * FROM transferencias
            WHERE usuario_origen_id = :usuario_id
            OR usuario_destino_id = :usuario_id
            ORDER BY id DESC";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':usuario_id' => $usuarioId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
}
