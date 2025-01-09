<?php
function getSellPoint($pdo, $page, $perPage, $who, $sens)
{
    if($page !== 1) {
        $curentid = $page * $perPage - $perPage;
    }
    $query = "SELECT sell_point.id, sell_point.name, sell_point.manager, sell_point.department, `g`.name AS group_name FROM sell_point LEFT JOIN geoloc_projet.`groups` g on g.id = sell_point.group_id";

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