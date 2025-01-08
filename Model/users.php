<?php
function getUsers($pdo, $page, $perPage)
{
    if($page !== 1) {
        $curentid = $page * $perPage - $perPage;
    }
    $query = "SELECT `id`, `email`, `is_active` FROM `users` LIMIT $perPage";

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