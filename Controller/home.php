<?php
/**
 * @var PDO $pdo
*/
require './Model/home.php';
require './Model/sell-point.php';
require './Model/users.php';

$totalSellPoint = getNbPage($pdo);
$totaluser = getPageNumbers($pdo);

require './View/home.php';