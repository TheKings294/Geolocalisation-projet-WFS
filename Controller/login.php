<?php
/**
 * @var PDO $pdo
*/
require './Model/login.php';

    if (!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
        $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
    ) {
        $email = isset($_POST['email']) ? cleanCodeString($_POST['email']) : '';
        $password = isset($_POST['password']) ? cleanCodeString($_POST['password']) : '';

        if (empty($email) || empty($password)) {
            http_reponse_error('email or password is required');
            exit();
        }

        $user = getUser($pdo, $email);

        if (!is_array($user)) {
            http_reponse_error('this user not exist');
            exit();
        }

        $isMatchPassword = password_verify($password, $user['password']);

        if ($isMatchPassword && $user['is_active']) {
            $_SESSION['auth'] = true;
            $_SESSION['username'] = $user['email'];
            $_SESSION['userId'] = $user['id'];
            setcookie('user_id', $user['id'], time() + (86400 * 30), "/");
            http_reponse_success();
            exit();
        } elseif ($isMatchPassword && !$user['is_active']) {
            http_reponse_error('this user is not active');
            exit();
        } else {
            http_reponse_error('password is wrong');
            exit();
        }
    }

require './View/login.php';