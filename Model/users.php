<?php
function getUsers($pdo, $page, $perPage, $who, $sens)
{
    if($page !== 1) {
        $curentid = $page * $perPage - $perPage;
    }
    $query = "SELECT `id`, `email`, `is_active` FROM `users`";

    if($who !== null && $sens !== null) {
        $query .= " ORDER BY `$who` $sens";
    }

    $query .= " LIMIT $perPage";

    if($page !== 1) {
        $query .= " OFFSET :idstart";
    }
    try {
        $stmt = $pdo->prepare($query);
        if($page !== 1) {
            $stmt->bindParam(":idstart", $curentid, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function getPageNumbers($pdo)
{
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS nb FROM `users`");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function deleteUser($pdo, $id): bool | string
{
    try {
        $stmt = $pdo->prepare("DELETE FROM `users` WHERE `id` = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}