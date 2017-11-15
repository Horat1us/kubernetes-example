<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");
$hostname = getenv("DB_HOSTNAME");
$port = getenv("DB_PORT");

$database = getenv("DB_NAME");

$connection = new \PDO("pgsql:dbname={$database};host=$hostname;port=$port", $username, $password);
$postgres = $connection->query("SELECT version();", PDO::FETCH_ASSOC)->fetchColumn();

$info = [
    "status" => "online",
    "postgres" => $postgres,
    "php" => PHP_VERSION,
    "system" => php_uname(),
    "faker" => \Faker\Factory::create()->name,
];

header("Content-Type", "application/json");
echo json_encode($info);
