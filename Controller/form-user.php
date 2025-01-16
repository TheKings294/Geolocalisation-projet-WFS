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
            $email = isset($_POST['email']) ? cleanCodeString($_POST['email']) : null;
            $password = isset($_POST['password']) ? cleanCodeString($_POST['password']) : null;
            $check_password = isset($_POST['check-password']) ? cleanCodeString($_POST['check-password']) : null;
            $is_active = isset($_POST['is-active']);

            if($email === null || $password === null) {
                header('Content-type: application/json');
                echo json_encode(['error' => 'email or password invalid']);
                exit();
            }
            if($password !== $check_password) {
                header('Content-type: application/json');
                echo json_encode(['error' => 'password not matched']);
                exit();
            }
            $password = password_hash($password, PASSWORD_DEFAULT);
            $check_password = null;

            $res = setUser($pdo, $email, $password, $is_active);
            if(!is_bool($res)) {
                header('Content-type: application/json');
                echo json_encode(['error' => $res]);
                exit();
            }
            header('Content-type: application/json');
            echo json_encode(['successfull' => 'user created']);
            break;
        case 'edit':
            $email = isset($_POST['email']) ? cleanCodeString($_POST['email']) : null;
            $password = isset($_POST['password']) ? cleanCodeString($_POST['password']) : null;
            $check_password = isset($_POST['check-password']) ? cleanCodeString($_POST['check-password']) : null;
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            $id = isset($_GET['id']) ? cleanCodeString($_GET['id']) : null;

            if($email === null) {
                header('Content-type: application/json');
                echo json_encode(['error' => 'email required']);
                exit();
            }
            $res = updateUser($pdo, $id, $email, $is_active);

            if($password && $check_password !== null) {
                $password = $password === $check_password ? password_hash($password, PASSWORD_DEFAULT) : null;
                if($password === null) {
                    header('Content-type: application/json');
                    echo json_encode(['error' => 'password and check password invalid']);
                    exit();
                }
                $check_password = null;
                $result = updatePassword($pdo, $password, $id);
            }
            if(is_bool($res) || is_bool($result)) {
                header('Content-type: application/json');
                echo json_encode(['successfull' => 'user updated']);
                exit();
            } else {
                header('Content-type: application/json');
                echo json_encode(['error' => [$res, $result]]);
            }
            break;
    }
    exit();
}

require './View/form-user.php';