<?php
function getUser($pdo, $id): array | string
{
    try {
        $stmt = $pdo->prepare("SELECT `id`,`email`, `is_active` FROM users WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function setUser($pdo, $email, $password, $is_active): bool | string
{
    try {
        $stmt = $pdo->prepare('INSERT INTO `users` (email, password, is_active) VALUES (:email, :password, :is_active)');
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue(":is_active", $is_active, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function updateUser($pdo, $id, $email, $is_active): bool | string
{
    try {
        $stmt = $pdo->prepare('UPDATE `users` SET email = :email, is_active = :is_active WHERE id = :id');
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":is_active", $is_active, PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function updatePassword($pdo, $id, $password): bool | string
{
    try {
        $stmt = $pdo->prepare('UPDATE `users` SET password = :password WHERE id = :id');
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function verifEmail(PDO $pdo, string $email, int $id = null): array | string
{
    $query = "SELECT COUNT(*) AS usernb FROM users WHERE email = :email";
    if ($id != null) {
        $query .= " AND id <> :id";
    }
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        if($id != null) {
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}