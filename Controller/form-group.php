<?php
/**
 * @var PDO $pdo
 * @var object $appLogger
 * @var object $apiLogger
*/
require './Model/form-group.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'get':
                $id = isset($_GET['id']) ? intval(cleanCodeString($_GET['id'])) : null;
                if ($id === null) {
                    http_reponse_error('id cannot be null');
                    exit();
                }
                $res = getGroup($pdo, $id);
                if (is_string($res)) {
                    http_reponse_error('Impossible to get sell point !');
                    $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res,  [
                        'file' => __FILE__,
                    ]);
                    exit();
                }
                http_response_result($res);
                break;
            case 'new':
                $name = isset($_POST['name']) ? cleanCodeString($_POST['name']) : null;
                $color = isset($_POST['color']) ? cleanCodeString($_POST['color']) : null;

                if($name === null || $color === null) {
                    http_reponse_error('name or clor cannot be null !');
                    exit();
                }

                $res = setGroup($pdo, $name, $color);
                if (is_string($res)) {
                    http_reponse_error('Impossible to set sell point !');
                    $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res,  [
                        'file' => __FILE__,
                    ]);
                    exit();
                }
                http_reponse_success();
                break;
            case 'edit':
                $id = isset($_GET['id']) ? intval(cleanCodeString($_GET['id'])) : null;
                $name = isset($_POST['name']) ? cleanCodeString($_POST['name']) : null;
                $color = isset($_POST['color']) ? cleanCodeString($_POST['color']) : null;

                if($id === null || $name === null || $color === null) {
                    http_reponse_error('name or color or id cannot be null !');
                    exit();
                }
                $res = updateGroup($pdo, $name, $color, $id);
                if (is_string($res)) {
                    http_reponse_error('Impossible to update sell point !');
                    $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res,  [
                        'file' => __FILE__,
                    ]);
                    exit();
                }
                http_reponse_success();
                break;
        }
        exit();
    }
}

require 'View/form-group.php';