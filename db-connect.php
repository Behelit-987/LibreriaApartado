<?php
// db-connect.php

$host = 'c2740aef72bd'; // Cambia esto según tu configuración
$username = 'root';
$password = 'root';
$dbname = 'dummy_db';

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// No es necesario devolver la conexión; 
// puedes usar $conn directamente en otros archivos.
?>
