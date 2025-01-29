<?php
/**
 * @var PDO $pdo
 * @var object $appLogger
 * @var object $apiLogger
 */
require './Model/groups.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if (!isset($_GET['action'])) {
        exit();
    }
    switch ($_GET['action']) {
        case 'groups':
            $page = isset($_GET['page']) ? cleanCodeString(intval($_GET['page'])) : 1;
            $who = isset($_GET['who']) ? cleanCodeString($_GET['who']) : null;
            $sens = isset($_GET['sens']) ? cleanCodeString($_GET['sens']) : null;

            $res = getGroups($pdo, $page,LIST_ITEM_PER_PAGE, $who, $sens);
            if (!is_array($res)) {
                http_reponse_error('les groups n ont pas pu être récupéré');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                    'file' => __FILE__,
                ]);
                exit();
            }
            http_response_result($res);
            break;
        case 'new':
            $name = isset($_POST['name']) ? cleanCodeString($_POST['name']) : null;
            $color = isset($_POST['color']) ? cleanCodeString($_POST['color']) : null;

            if (empty($name) || empty($color)) {
                http_reponse_error("Empty group name or color");
                exit();
            }
            $res = setGroups($pdo, $name, $color);
            if (is_string($res)) {
                http_reponse_error('Le group na pas pu être crée');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                    'file' => __FILE__,
                ]);
                exit();
            }
            http_reponse_success();
            break;
        case 'page':
            $res = getGroupNb($pdo);
            if (!is_array($res)) {
                http_reponse_error('The action canot be do');
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

require './View/groups.php';