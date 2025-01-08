<?php
/**
* @var PDO $pdo
 */
require './Model/users.php';
const LIST_PERSONS_ITEM_PER_PAGE = 15;

if(!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    switch ($_GET['action']) {
        case 'users':
            $page = isset($_GET['page']) ? cleanCodeString(intval($_GET['page'])) : 1;
            $res = getUsers($pdo, $page, LIST_PERSONS_ITEM_PER_PAGE);
            if(!is_array($res)) {
                header('Content-type: application/json');
                echo json_encode(['error' => $res]);
                exit();
            }
            header('Content-type: application/json');
            echo json_encode(['result' => $res]);
            break;
        case 'page':
            $res = getPageNumbers($pdo);
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



require './View/users.php';