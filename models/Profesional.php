<?php
// models/Profesional.php
require_once __DIR__ . '/BaseModel.php';

class Profesional extends BaseModel {
    protected $table = 'profesionales';

    public function all() {
        $stmt = $this->db()->query("SELECT * FROM {$this->table} WHERE activo = 1 ORDER BY apellido, nombre");
        return $stmt->fetchAll();
    }

    public function create(array $data) {
        if (empty($data['nombre']) || empty($data['apellido'])) {
            throw new InvalidArgumentException('El nombre y el apellido son datos requeridos.');
        }

        $this->db()->beginTransaction();
        try {
            $sql = "INSERT INTO {$this->table} (nombre, apellido, telefono, email, disponibilidad, activo) 
                    VALUES (:nombre, :apellido, :telefono, :email, :disponibilidad, 1)";
            $stmt = $this->db()->prepare($sql);
            $stmt->execute([
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'telefono' => $data['telefono'] ?? null,
                'email' => $data['email'] ?? null,
                'disponibilidad' => $data['disponibilidad'] ?? null,
            ]);

            $id_medico = $this->db()->lastInsertId();

            if (!empty($data['id_especialidad'])) {
                $sqlEsp = "INSERT INTO medico_especialidad (id_medico, id_especialidad) VALUES (:medico, :esp)";
                $stmtEsp = $this->db()->prepare($sqlEsp);
                $stmtEsp->execute([
                    'medico' => $id_medico,
                    'esp' => $data['id_especialidad']
                ]);
            }

            $this->db()->commit();
            return $id_medico;
        } catch (Exception $e) {
            $this->db()->rollBack();
            throw $e;
        }
    }

    public function find($id) {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}