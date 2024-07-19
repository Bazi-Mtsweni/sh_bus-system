<?php
session_start();

// Get .env
$envFilePath = __DIR__ . '/../includes/.env';
$env = parse_ini_file($envFilePath);

$servername = $env['SERVER'];
$username = $env['USERNAME'];
$password = $env['PASSWORD'];
$dbname = $env['DB_NAME'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
