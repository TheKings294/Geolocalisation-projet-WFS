<?php
/**
 * @var PDO $pdo
*/
function setNewSellPoint(
    PDO $pdo,
    string $name,
    string $siret,
    string $address,
    string $img,
    string $manager,
    $hourly,
    int $departement,
    string $x,
    string $y,
    int | null $group = null)
{
    if($group === 0) {
        $group = null;
    }
    try {
        $stmt = $pdo->prepare('INSERT INTO sell_point (name, siret, address, img, manager, hourly, department_id, coordonate_x, coordonate_y, group_id) 
VALUES (:name, :siret, :address, :img, :manger, :hourly, :departement, :x, :y, :group_id)');
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':siret', $siret);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':img', $img);
        $stmt->bindValue(':manger', $manager);
        $stmt->bindValue(':hourly', $hourly);
        $stmt->bindValue(':departement', $departement, PDO::PARAM_INT);
        $stmt->bindValue(':x', $x);
        $stmt->bindValue(':y', $y);
        $stmt->bindValue(':group_id', $group ?? null, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function getSellPoint(PDO $pdo, $id): array | string
{
    try {
        $stmt = $pdo->prepare('
SELECT sell_point.*, d.depart_num FROM sell_point LEFT JOIN geoloc_projet.department d on d.id = sell_point.department_id WHERE sell_point.id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function verifImage(PDO $pdo, int $id): array | string
{
    try {
        $stmt = $pdo->prepare('SELECT `img` FROM sell_point WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function updateSellPoint(
    PDO $pdo,
    int $id,
    string $name,
    string $siret,
    string $address,
    string | null $img,
    string $manager,
    $hourly,
    int $departement,
    string $x,
    string $y,
    int | null $group = null): bool | string
{
    $url = 'UPDATE sell_point SET name = :name, siret = :siret, address = :address,';
    if($img !== null) {
        $url .= 'img = :img,';
    }
    $url .= 'manager = :manager, hourly = :hourly, department_id = :departement, coordonate_x = :x, coordonate_y = :y, group_id = :group_id WHERE id = :id';
    try {
        $stmt = $pdo->prepare($url);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':siret', $siret);
        $stmt->bindValue(':address', $address);
        if($img !== null) {
            $stmt->bindValue(':img', $img);
        }
        $stmt->bindValue(':manager', $manager);
        $stmt->bindValue(':hourly', $hourly);
        $stmt->bindValue(':departement', $departement, PDO::PARAM_INT);
        $stmt->bindValue(':x', $x);
        $stmt->bindValue(':y', $y);
        $stmt->bindValue(':group_id', $group ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function deletImage(PDO $pdo, int $id): bool | string
{
    try {
        $stmt = $pdo->prepare('UPDATE sell_point SET img = :img WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':img', null, PDO::PARAM_NULL);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
function getDepartement(PDO $pdo, string $num): array | string
{
    try {
        $stmt = $pdo->prepare('SELECT id FROM department WHERE depart_num = :num');
        $stmt->bindValue(':num', $num);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}