<?php
// test_db.php - prueba rápida de conexión a la BD
try {
    $pdo = require __DIR__ . '/config/database.php';
    $stmt = $pdo->query("SELECT 'OK' AS status");
    $row = $stmt->fetch();
    echo "Conexión OK: " . $row['status'];
} catch (Exception $e) {
    echo "Error al conectar: " . $e->getMessage();
}