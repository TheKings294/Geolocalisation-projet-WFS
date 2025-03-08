<?php
/**
* @var PDO $pdo
 */
function getUser(PDO $pdo, $email)
{
    try {
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        return $statement->fetch();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}