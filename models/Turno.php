<?php
// models/Turno.php
require_once __DIR__ . '/BaseModel.php';

class Turno extends BaseModel
{
    protected $table = 'turnos';

    public function all()
    {
        $stmt = $this->db()->query("SELECT * FROM {$this->table} WHERE activo = 1 ORDER BY inicio DESC");
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Verifica solapamiento estricto para un profesional.
     */
    public function hasOverlap($profesional_id, $inicio, $duracion_min, $excludeId = null)
    {
        // Calculamos el fin del turno que se intenta agendar
        $fin_propuesto = date('Y-m-d H:i:s', strtotime("+$duracion_min minutes", strtotime($inicio)));

        // SQL: Hay solapamiento si existe un turno que:
        // El inicio de un turno existente es antes que el FIN del nuevo
        // Y el fin de un turno existente es después que el INICIO del nuevo
        $sql = "
            SELECT COUNT(*) FROM {$this->table}
            WHERE profesional_id = ?
              AND activo = 1
              AND estado != 'cancelado'
              AND (
                inicio < ? AND DATE_ADD(inicio, INTERVAL duracion_min MINUTE) > ?
              )
        ";

        $params = [$profesional_id, $fin_propuesto, $inicio];

        if ($excludeId !== null) {
            $sql .= " AND id != ?";
            $params[] = (int)$excludeId;
        }

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function create(array $data)
    {
        if (empty($data['paciente_id']) || empty($data['profesional_id']) || empty($data['inicio']) || empty($data['duracion_min'])) {
            throw new InvalidArgumentException('Paciente, profesional, inicio y duración son obligatorios.');
        }

        // VALIDACIÓN DE SOLAPAMIENTO
        if ($this->hasOverlap($data['profesional_id'], $data['inicio'], $data['duracion_min'])) {
            throw new RuntimeException('El profesional ya tiene un compromiso en ese rango horario.');
        }

        $sql = "INSERT INTO {$this->table} (paciente_id, profesional_id, inicio, duracion_min, motivo, estado, activo)
                VALUES (:paciente_id, :profesional_id, :inicio, :duracion_min, :motivo, :estado, 1)";
        
        $stmt = $this->db()->prepare($sql);
        $params = [
            'paciente_id'   => $data['paciente_id'],
            'profesional_id' => $data['profesional_id'],
            'inicio'         => $data['inicio'],
            'duracion_min'   => (int)$data['duracion_min'],
            'motivo'         => $data['motivo'] ?? null,
            'estado'         => $data['estado'] ?? 'agendado',
        ];
        
        $stmt->execute($params);
        return $this->db()->lastInsertId();
    }

    public function update($id, array $data)
    {
        $turno = $this->find($id);
        if (!$turno) throw new RuntimeException("Turno no encontrado.");

        $paciente_id = $data['paciente_id'] ?? $turno['paciente_id'];
        $profesional_id = $data['profesional_id'] ?? $turno['profesional_id'];
        $inicio = $data['inicio'] ?? $turno['inicio'];
        $duracion_min = isset($data['duracion_min']) ? (int)$data['duracion_min'] : (int)$turno['duracion_min'];
        $motivo = $data['motivo'] ?? $turno['motivo'];
        $estado = $data['estado'] ?? $turno['estado'];

        if ($this->hasOverlap($profesional_id, $inicio, $duracion_min, $id)) {
            throw new RuntimeException('El profesional ya tiene un turno solapado en ese horario.');
        }

        $sql = "UPDATE {$this->table} SET paciente_id = :paciente_id, profesional_id = :profesional_id,
                inicio = :inicio, duracion_min = :duracion_min, motivo = :motivo, estado = :estado
                WHERE id = :id";
        
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute([
            'paciente_id'    => $paciente_id,
            'profesional_id' => $profesional_id,
            'inicio'         => $inicio,
            'duracion_min'   => $duracion_min,
            'motivo'         => $motivo,
            'estado'         => $estado,
            'id'             => $id,
        ]);
    }

    public function markAsCancelled($id)
    {
        $stmt = $this->db()->prepare("UPDATE {$this->table} SET estado = 'cancelado' WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function markAsAttended($id)
    {
        $stmt = $this->db()->prepare("UPDATE {$this->table} SET estado = 'atendido' WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getForDay(string $date, $profesional_id = null)
    {
        $start = $date . ' 00:00:00';
        $end = $date . ' 23:59:59';
        $sql = "SELECT * FROM {$this->table} WHERE activo = 1 AND inicio BETWEEN :start AND :end";
        $params = ['start' => $start, 'end' => $end];
        
        if ($profesional_id) {
            $sql .= " AND profesional_id = :prof";
            $params['prof'] = $profesional_id;
        }
        
        $sql .= " ORDER BY inicio ASC";
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}