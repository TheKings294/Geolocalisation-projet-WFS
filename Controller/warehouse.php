<?php
/**
 * @var PDO $pdo
 * @var object $appLogger
 * @var object $apiLogger
*/
require './Model/warehouse.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'warehouse':
                $page = isset($_GET['page']) ? cleanCodeString(intval($_GET['page'])) : 1;
                $who = isset($_GET['who']) ? cleanCodeString($_GET['who']) : null;
                $sens = isset($_GET['sens']) ? cleanCodeString($_GET['sens']) : null;

                $res = getWarehouses($pdo, $page, LIST_ITEM_PER_PAGE, $who, $sens, null);
                if (is_string($res)) {
                    http_reponse_error('An error occured while retrieving warehouses.');
                    $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                        'file' => __FILE__,
                    ]);
                    exit();
                }
                http_response_result($res);
                break;
            case 'page':
                $res = getNbPage($pdo);
                if (is_string($res)) {
                    http_reponse_error('An error occured while retrieving pages.');
                    $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                        'file' => __FILE__,
                    ]);
                    exit();
                }
                http_response_result($res);
                break;
        }
        exit();
    }
}

require './View/warehouse.php';