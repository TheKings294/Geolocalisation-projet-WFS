<?php
/**
* @var PDO $pdo
 * @var object $appLogger
 * @var object $apiLogger
 */
require './Model/users.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    switch ($_GET['action']) {
        case 'users':
            $page = isset($_GET['page']) ? cleanCodeString(intval($_GET['page'])) : 1;
            $who = isset($_GET['who']) ? cleanCodeString($_GET['who']) : null;
            $sens = isset($_GET['sens']) ? cleanCodeString($_GET['sens']) : null;

            $res = getUsers($pdo, $page, LIST_ITEM_PER_PAGE, $who, $sens);
            if (!is_array($res)) {
                http_reponse_error('Une erreur s\'est produite lors de l\'éxécution');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res);
                exit();
            }
            http_response_result($res);
            break;
        case 'page':
            $res = getPageNumbers($pdo);
            if (!is_array($res)) {
                http_reponse_error('Une erreur s\'est produite lors de l\'éxécution');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res);
                exit();
            }
            http_response_result($res);
            break;
        case 'delete':
            $id = isset($_GET['id']) ? intval(cleanCodeString($_GET['id'])) : null;
            if ($id === null) {
                http_reponse_error('id cannot be null');
                exit();
            } elseif ($id === $_SESSION['userId']) {
                http_reponse_error('You can t delete your user');
            }
            $res = deleteUser($pdo, $id);
            if (is_string($res)) {
                http_reponse_error('L\'utilisateur n\'a pas pu être suprimé');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res);
                exit();
            }
            http_reponse_success();
            break;
    }
    exit();
}



require './View/users.php';