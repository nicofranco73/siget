<?php
// models/historial.php
require_once __DIR__ . '/BaseModel.php'; 

class Historial extends BaseModel { 

    public function obtener_por_paciente($id_paciente) {
        try {
            // Quitamos el JOIN con especialidades para probar si es eso lo que rompe
            $sql = "SELECT * FROM historial_consulta 
                    WHERE id_paciente = :id_paciente 
                    ORDER BY fecha_consulta DESC";
            
            $stmt = $this->db()->prepare($sql);
            $stmt->execute([':id_paciente' => $id_paciente]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si esto falla, te va a decir EXACTAMENTE por qué
            die("Error en la base de datos: " . $e->getMessage());
        }
    }
}