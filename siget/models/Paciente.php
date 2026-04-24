<?php
// models/Paciente.php
require_once __DIR__ . '/BaseModel.php';

class Paciente extends BaseModel
{
    protected $table = 'pacientes';

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
        if (empty($data['nombre']) || empty($data['apellido']) || empty($data['dni'])) {
            throw new InvalidArgumentException('Nombre, apellido y DNI son obligatorios.');
        }

        $stmt = $this->db()->prepare("SELECT COUNT(*) FROM {$this->table} WHERE dni = :dni AND activo = 1");
        $stmt->execute(['dni' => $data['dni']]);
        if ($stmt->fetchColumn() > 0) {
            throw new RuntimeException('Ya existe un paciente con ese DNI.');
        }

        $sql = "INSERT INTO {$this->table} (nombre, apellido, dni, fecha_nac, telefono, email, direccion) 
                VALUES (:nombre, :apellido, :dni, :fecha_nac, :telefono, :email, :direccion)";
        $stmt = $this->db()->prepare($sql);
        $params = [
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'dni' => $data['dni'],
            'fecha_nac' => $data['fecha_nac'] ?? null,
            'telefono' => $data['telefono'] ?? null,
            'email' => $data['email'] ?? null,
            'direccion' => $data['direccion'] ?? null,
        ];
        $stmt->execute($params);
        return $this->db()->lastInsertId();
    }

    public function update($id, array $data)
    {
        // ... (Tu código de update se mantiene igual)
        if (empty($data['nombre']) || empty($data['apellido'])) {
            throw new InvalidArgumentException('Nombre y apellido son obligatorios.');
        }
        $sql = "UPDATE {$this->table} SET nombre = :nombre, apellido = :apellido, dni = :dni,
                fecha_nac = :fecha_nac, telefono = :telefono, email = :email, direccion = :direccion
                WHERE id = :id";
        $stmt = $this->db()->prepare($sql);
        $params = [
            'nombre' => $data['nombre'], 'apellido' => $data['apellido'], 'dni' => $data['dni'] ?? null,
            'fecha_nac' => $data['fecha_nac'] ?? null, 'telefono' => $data['telefono'] ?? null,
            'email' => $data['email'] ?? null, 'direccion' => $data['direccion'] ?? null, 'id' => $id,
        ];
        return $stmt->execute($params);
    }

    public function softDelete($id)
    {
        $stmt = $this->db()->prepare("UPDATE {$this->table} SET activo = 0 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}