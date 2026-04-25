<?php
// models/Profesional.php
require_once __DIR__ . '/BaseModel.php';

class Profesional extends BaseModel
{
    protected $table = 'profesionales';

    public function all()
    {
        $stmt = $this->db()->query("SELECT * FROM {$this->table} WHERE activo = 1 ORDER BY apellido, nombre");
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        if (empty($data['nombre']) || empty($data['apellido'])) {
            throw new InvalidArgumentException('Nombre y apellido son obligatorios.');
        }

        // Verificar email único si viene informado
        if (!empty($data['email'])) {
            $stmt = $this->db()->prepare("SELECT COUNT(*) FROM {$this->table} WHERE email = :email AND activo = 1");
            $stmt->execute(['email' => $data['email']]);
            if ($stmt->fetchColumn() > 0) {
                throw new RuntimeException('Ya existe un profesional con ese email.');
            }
        }

        $sql = "INSERT INTO {$this->table} (nombre, apellido, especialidad, telefono, email, disponibilidad) 
                VALUES (:nombre, :apellido, :especialidad, :telefono, :email, :disponibilidad)";
        $stmt = $this->db()->prepare($sql);
        $params = [
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'especialidad' => $data['especialidad'] ?? null,
            'telefono' => $data['telefono'] ?? null,
            'email' => $data['email'] ?? null,
            'disponibilidad' => $data['disponibilidad'] ?? null, // guardar JSON o texto
        ];
        $stmt->execute($params);
        return $this->db()->lastInsertId();
    }

    public function update($id, array $data)
    {
        if (empty($data['nombre']) || empty($data['apellido'])) {
            throw new InvalidArgumentException('Nombre y apellido son obligatorios.');
        }

        if (!empty($data['email'])) {
            $stmt = $this->db()->prepare("SELECT COUNT(*) FROM {$this->table} WHERE email = :email AND id != :id AND activo = 1");
            $stmt->execute(['email' => $data['email'], 'id' => $id]);
            if ($stmt->fetchColumn() > 0) {
                throw new RuntimeException('Otro profesional ya tiene ese email.');
            }
        }

        $sql = "UPDATE {$this->table} SET nombre = :nombre, apellido = :apellido, especialidad = :especialidad,
                telefono = :telefono, email = :email, disponibilidad = :disponibilidad
                WHERE id = :id";
        $stmt = $this->db()->prepare($sql);
        $params = [
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'especialidad' => $data['especialidad'] ?? null,
            'telefono' => $data['telefono'] ?? null,
            'email' => $data['email'] ?? null,
            'disponibilidad' => $data['disponibilidad'] ?? null,
            'id' => $id,
        ];
        return $stmt->execute($params);
    }

    public function softDelete($id)
    {
        $stmt = $this->db()->prepare("UPDATE {$this->table} SET activo = 0 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}