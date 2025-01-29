<?php
function getGroups($pdo, $page, $perPage, $who, $sens): string | array
{
    if ($page !== 1) {
        $curentid = $page * $perPage - $perPage;
    }
    $query = "SELECT * FROM `groups`";

    if($who !== null && $sens !== null) {
        $query .= " ORDER BY `$who` $sens";
    }

    $query .= " LIMIT $perPage";

    if ($page !== 1) {
        $query .= " OFFSET :idstart";
    }

    try {
        $stmt = $pdo->prepare($query);
        if ($page !== 1) {
            $stmt->bindParam(":idstart", $curentid, PDO::PARAM_INT);
        }
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
function getGroupNb($pdo): array | string
{
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS nb FROM `groups`");
        $stmt->execute();
        return $stmt->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}