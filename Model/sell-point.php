<?php
function getSellPoint($pdo, $page, $perPage, $who, $sens, $all)
{
    if($page !== 1) {
        $curentid = $page * $perPage - $perPage;
    }
    $query = "SELECT sell_point.*, d.name AS dep_name, g.color, g.name AS group_name FROM sell_point 
    LEFT JOIN geoloc_projet.`groups` g on g.id = sell_point.group_id 
    LEFT JOIN geoloc_projet.department d on sell_point.department_id = d.id";

    if($who !== null && $sens !== null) {
        $query .= " ORDER BY `$who` $sens";
    }
    if($all === null) {
        $query .= " LIMIT $perPage";
    }

    if($all === null) {
        $query .= " OFFSET :idstart";
    }
    try {
        $stmt = $pdo->prepare($query);
        if($all === null) {
            $stmt->bindParam(":idstart", $curentid, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function  getNbPage($pdo)
{
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS nb FROM `sell_point`");
        $stmt->execute();
        return $stmt->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function deleteSellPoint($pdo, $id): bool | string
{
    try {
        $stmt = $pdo->prepare("DELETE FROM `sell_point` WHERE `id` = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}