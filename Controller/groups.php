<?php
/**
 * @var PDO $pdo
 */
require './Model/groups.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if(!isset($_GET['action'])) {
        exit();
    }
    switch ($_GET['action']) {
        case 'getall':
            $res = getGroups($pdo);
            if(!is_array($res)) {
                http_reponse_error($res);
                exit();
            }
            http_response_result($res);
            break;
    }
    exit();
}

require './View/groups.php';