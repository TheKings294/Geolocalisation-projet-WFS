<?php
/**
 * @var PDO $pdo
*/
require './Model/home.php';
require './Model/sell-point.php';
require './Model/users.php';
require 'Model/form-group.php';

$totalSellPoint = getNbPage($pdo);
$totaluser = getPageNumbers($pdo);
$totalGroup = countGroups($pdo);

require './View/home.php';