<?php
/**
 * @var PDO $pdo
*/
require './Model/sell-point.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    switch ($_GET['action']) {
        case 'sell-point':
            $page = isset($_GET['page']) ? cleanCodeString(intval($_GET['page'])) : 1;
            $who = isset($_GET['who']) ? cleanCodeString($_GET['who']) : null;
            $sens = isset($_GET['sens']) ? cleanCodeString($_GET['sens']) : null;
            $res = getSellPoint($pdo, $page, LIST_ITEM_PER_PAGE, $who, $sens);
            if(!is_array($res)) {
                header('Content-type: application/json');
                echo json_encode(['error' => $res]);
                exit();
            }
            header('Content-type: application/json');
            echo json_encode(['result' => $res]);
            break;
        case 'page':
            $res = getNbPage($pdo);
            if(!is_array($res)) {
                header('Content-type: application/json');
                echo json_encode(['error' => $res]);
                exit();
            }
            header('Content-type: application/json');
            echo json_encode(['result' => $res]);
            break;
    }
    exit();
}

require './View/sell-point.php';