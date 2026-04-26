<?php
// models/especialidad.php

class Especialidad extends BaseModel {
    protected $table = 'especialidades';

    /**
     * Obtiene todas las especialidades con el conteo de profesionales asignados
     */
    public function getAllWithCount() {
        $sql = "SELECT e.*, COUNT(me.id_medico) as total_profesionales 
                FROM {$this->table} e 
                LEFT JOIN medico_especialidad me ON e.id_especialidad = me.id_especialidad 
                GROUP BY e.id_especialidad 
                ORDER BY e.nombre ASC";
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllActive() {
        $sql = "SELECT * FROM {$this->table} WHERE activo = 1 ORDER BY nombre ASC";
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($nombre, $descripcion = '') {
        $sql = "INSERT INTO {$this->table} (nombre, descripcion, activo) VALUES (:nombre, :descripcion, 1)";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion
        ]);
    }
}