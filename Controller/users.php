<?php
/**
* @var PDO $pdo
 */
require './Model/users.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    switch ($_GET['action']) {
        case 'users':
            $page = isset($_GET['page']) ? cleanCodeString(intval($_GET['page'])) : 1;
            $who = isset($_GET['who']) ? cleanCodeString($_GET['who']) : null;
            $sens = isset($_GET['sens']) ? cleanCodeString($_GET['sens']) : null;
            $res = getUsers($pdo, $page, LIST_ITEM_PER_PAGE, $who, $sens);
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
        case 'delete':
            $id = isset($_GET['id']) ? intval(cleanCodeString($_GET['id'])) : null;
            if($id === null) {
                header('Content-type: application/json');
                echo json_encode(['error' => 'id cannot be null']);
                exit();
            } elseif ($id === $_SESSION['userId']) {
                header('Content-type: application/json');
                echo json_encode(['error' => 'You can t delete your user']);
            }
            $res = deleteUser($pdo, $id);
            if(is_string($res)) {
                header('Content-type: application/json');
                echo json_encode(['error' => $res]);
                exit();
            }
            header('Content-type: application/json');
            echo json_encode(['success' => $res]);
            break;
    }
    exit();
}



require './View/users.php';