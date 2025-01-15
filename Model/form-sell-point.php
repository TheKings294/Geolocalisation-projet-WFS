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
    string $departement,
    string $x,
    string $y,
    int | null $group = null)
{
    try {
        $stmt = $pdo->prepare('INSERT INTO sell_point (name, siret, address, img, manager, hourly, department, coordonate_x, coordonate_y, group_id) 
VALUES (:name, :siret, :address, :img, :manger, :hourly, :departement, :x, :y, :group_id)');
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':siret', $siret);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':img', $img);
        $stmt->bindValue(':manger', $manager);
        $stmt->bindValue(':hourly', $hourly);
        $stmt->bindValue(':departement', $departement);
        $stmt->bindValue(':x', $x);
        $stmt->bindValue(':y', $y);
        if($group !== null) {
            $stmt->bindValue(':group', $group, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':group', $group);
        }
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}