<?php
function getGroup($pdo, $id): array | string
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM `groups` WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function setGroup($pdo, $name, $color): bool | string
{
    try {
        $stmt = $pdo->prepare("INSERT INTO `groups` (`name`, `color`) VALUES (:name, :color)");
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":color", $color, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function updateGroup($pdo, $name, $color, $id): bool | string
{
    try {
        $stmt = $pdo->prepare("UPDATE `groups` SET `name` = :name, `color` = :color WHERE id = :id");
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":color", $color, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function countGroups($pdo): array | string
{
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS nb FROM `groups`");
        $stmt->execute();
        return $stmt->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }

}