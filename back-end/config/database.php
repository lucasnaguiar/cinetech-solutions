<?php
$db_host = $_ENV['DB_HOST'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];
$db_name = $_ENV['DB_NAME'];
$db_port = $_ENV['DB_PORT'];

return [
    "host" => $db_host,
    "port" => $db_port,
    "user" => $db_user,
    "dbname" => $db_name,
    'username' =>  $db_user,
    'password' => $db_pass,
    'dsn' => "mysql:host=$db_host;port=$db_port;dbname=$db_name", // Corrigido para MySQL
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_PERSISTENT => true, // Conexão persistente
    ],
];
