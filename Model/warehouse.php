<?php
function getWarehouses($pdo, $page, $perPage, $who, $sens, $all): array | string
{
    if ($page !== 1) {
        $curentid = $page * $perPage - $perPage;
    }
    $query = "SELECT warehouse.*, d.name AS department, r.nom AS region FROM warehouse 
    LEFT JOIN department d on d.id = warehouse.department_id 
    LEFT JOIN region r on warehouse.region_id = r.id";

    if ($who !== null && $sens !== null) {
        $query .= " ORDER BY $who $sens";
    }
    if ($all === null) {
        $query .= " LIMIT $perPage";
    }

    if ($all === null) {
        $query .= " OFFSET :idstart";
    }
    try {
        $stmt = $pdo->prepare($query);
        if ($all === null) {
            $stmt->bindParam(":idstart", $curentid, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function getNbPage($pdo): array | string
{
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS nb FROM warehouse");
        $stmt->execute();
        return $stmt->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}