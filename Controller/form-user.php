<?php
/**
 * @var PDO $pdo
 * @var object $appLogger
 * @var object $apiLogger
 */
require './Model/form-user.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if (!isset($_GET['action']) && !isset($_GET['id'])) {
        exit();
    }
    switch($_GET['action']) {
        case 'get':
            $id = isset($_GET['id']) ? cleanCodeString($_GET['id']) : null;

            if ($id === null) {
                http_reponse_error('id connot be null');
                exit();
            }
            if (!is_numeric($id)) {
                http_reponse_error('Id must be numeric');
                exit();
            }

            $res = getUser($pdo, $id);
            if (!is_array($res)) {
                http_reponse_error('le user n a pas pu être récupéré');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                    'file' => __FILE__,
                ]);
                exit();
            }
            http_response_result($res);
            break;
        case 'new':
            $email = isset($_POST['email']) ? cleanCodeString($_POST['email']) : null;
            $password = isset($_POST['password']) ? cleanCodeString($_POST['password']) : null;
            $check_password = isset($_POST['check-password']) ? cleanCodeString($_POST['check-password']) : null;
            $is_active = isset($_POST['is-active']);

            if ($email === null || $password === null) {
                http_reponse_error('email or password invalid');
                exit();
            }
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                http_reponse_error('email invalid');
                exit();
            }
            if ($password !== $check_password) {
                http_reponse_error('password not matched');
                exit();
            }
            $password = password_hash($password, PASSWORD_DEFAULT);
            $check_password = null;

            $check_eamil = verifEmail($pdo, $email);
            if ($check_eamil['usernb'] !== 0) {
                http_reponse_error('email already exists');
                exit();
            }

            $res = setUser($pdo, $email, $password, $is_active);
            if (!is_bool($res)) {
                http_reponse_error('le user n a pas pu être crée');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                    'file' => __FILE__,
                ]);
                exit();
            }
            http_reponse_success();
            break;
        case 'edit':
            $email = isset($_POST['email']) ? cleanCodeString($_POST['email']) : null;
            $password = isset($_POST['password']) ? cleanCodeString($_POST['password']) : null;
            $check_password = isset($_POST['check-password']) ? cleanCodeString($_POST['check-password']) : null;
            $is_active = isset($_POST['is-active']);
            $id = isset($_GET['id']) ? cleanCodeString($_GET['id']) : null;

            if ($email === null) {
               http_reponse_error('email required');
                exit();
            }
            $check_eamil = verifEmail($pdo, $email, $id);
            if ($check_eamil['usernb'] !== 0) {
                http_reponse_error('email already exists');
                exit();
            }
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                http_reponse_error('email invalid');
                exit();
            }

            $res = updateUser($pdo, $id, $email, $is_active);
            if (is_string($res)) {
                http_reponse_error('le user n a pas pu être edité');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                    'file' => __FILE__,
                ]);
                exit();
            }

            if ($password && $check_password !== null) {
                $password = $password === $check_password ? password_hash($password, PASSWORD_DEFAULT) : null;
                if($password === null) {
                    http_reponse_error('password and check password invalid');
                    exit();
                }
                $check_password = null;
                $result = updatePassword($pdo, $password, $id);
                if (is_string($result)) {
                    http_reponse_error('le mot de passe na pas pu être edité');
                    $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $result, [
                        'file' => __FILE__,
                    ]);
                    exit();
                }
            }
            if (is_bool($res) || is_bool($result)) {
                http_reponse_success();
            }
            break;
    }
    exit();
}

require './View/form-user.php';