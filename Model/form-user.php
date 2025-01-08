<?php
function getUser($pdo, $id): array | string
{
    try {
        $stmt = $pdo->prepare("SELECT `email`, `is_active` FROM users WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}