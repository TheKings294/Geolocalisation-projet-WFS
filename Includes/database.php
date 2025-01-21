<?php
require "vendor/autoload.php";
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
try {
    $pdo = new PDO('mysql:host='.$_ENV['BDD_URL'] . ';dbname=' . $_ENV['BDD_NAME'], $_ENV['BDD_USERNAME'], $_ENV['BDD_PASSWORD']);
} catch (Exception $e) {
    $error[] = "BDD conect error : {$e->getMessage()}";
}

