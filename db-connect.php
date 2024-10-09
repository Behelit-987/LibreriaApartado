<?php
$mysqli = new mysqli('mysql-container', 'root', 'root', 'dummy_db');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>