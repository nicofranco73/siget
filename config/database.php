<?php
// config/database.php - ajustar credenciales según XAMPP
return (function () {
    $config = [
        'host' => '127.0.0.1',
        'port' => 3306,
        'dbname' => 'siget',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ];

    $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $config['host'], $config['port'], $config['dbname'], $config['charset']);

    try {
        $pdo = new PDO($dsn, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        exit('Error de conexión a la base de datos: ' . $e->getMessage());
    }
})();