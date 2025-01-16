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