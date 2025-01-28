<?php
/**
 * @var PDO $pdo
 * @var object $appLogger
 * @var object $apiLogger
*/
require './Model/map.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if (isset($_GET['action'])) {
        switch($_GET['action']) {
            case 'get_departments':
                $res = get_departments($pdo);
                if(is_string($res)) {
                    http_reponse_error('Une erreur est survenue lors de la recherche des départements.');
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
}

require './View/map.php';