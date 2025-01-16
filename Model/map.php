<?php
function get_departments(PDO $pdo): array | string
{
    try {
        $statement = $pdo->prepare("SELECT * FROM department");
        $statement->execute();
        return $statement->fetchAll();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}