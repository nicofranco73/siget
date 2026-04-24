<?php
// models/especialidad.php

class Especialidad extends BaseModel {
    protected $table = 'especialidades';

    public function getAllActive() {
        $sql = "SELECT * FROM {$this->table} WHERE activo = 1 ORDER BY nombre ASC";
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($nombre, $descripcion = '') {
        $sql = "INSERT INTO {$this->table} (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion
        ]);
    }
}