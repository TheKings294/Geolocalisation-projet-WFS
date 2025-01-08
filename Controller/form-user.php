<?php
/**
 * @var PDO $pdo
 */
require './Model/form-user.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if(!isset($_GET['action']) && !isset($_GET['id'])) {
        exit();
    }
    switch($_GET['action']) {
        case 'get':
            $res = getUser($pdo, $_GET['id']);
            if(!is_array($res)) {
                header('Content-type: application/json');
                echo json_encode(['error' => $res]);
                exit();
            }
            header('Content-type: application/json');
            echo json_encode(['result' => $res]);
            break;
        case 'new':
            $email = isset($_POST['email']) ? cleanCodeString($_POST['email']) : '';
            $password = isset($_POST['password']) ? cleanCodeString($_POST['password']) : '';
            break;
        case 'edit':
            break;
    }
    exit();
}

require './View/form-user.php';