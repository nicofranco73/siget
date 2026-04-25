<?php
$password = 'admin';
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
echo "<h1>Hash para la contraseña 'admin':</h1>";
echo "<p><strong>" . $hash . "</strong></p>";
echo "<p>Copia este hash y úsalo en tu UPDATE SQL</p>";
?>