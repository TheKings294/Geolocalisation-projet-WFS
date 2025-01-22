<?php
/**
 * @var PDO $pdo
*/
require './Model/map.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if(isset($_GET['action'])) {
        switch($_GET['action']) {
            case 'get_departments':
                $res = get_departments($pdo);
                if(is_string($res)) {
                    http_reponse_error($res);
                    exit();
                }
                http_response_result($res);
                break;
        }
        exit();
    }
}

require './View/map.php';