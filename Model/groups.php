<?php
function getGroups($pdo): string | array
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM `groups`");
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function setGroups($pdo, $name, $color): bool | string
{
    try {
        $stmt = $pdo->prepare("INSERT INTO `groups` (`name`, `color`) VALUES (:name, :color)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":color", $color);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}