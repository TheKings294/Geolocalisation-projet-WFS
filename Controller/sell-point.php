<?php
/**
 * @var PDO $pdo
 * @var object $appLogger
 * @var object $apiLogger
*/
require './Model/sell-point.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    switch ($_GET['action']) {
        case 'sell-point':
            $page = isset($_GET['page']) ? cleanCodeString(intval($_GET['page'])) : 1;
            $who = isset($_GET['who']) ? cleanCodeString($_GET['who']) : null;
            $sens = isset($_GET['sens']) ? cleanCodeString($_GET['sens']) : null;

            $res = getSellPoint($pdo, $page, LIST_ITEM_PER_PAGE, $who, $sens, null);
            if (!is_array($res)) {
                http_response_result('Une erreur s\'est produite lors de la récupération.');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                    'file' => __FILE__,
                ]);
                exit();
            }
            http_response_result($res);
            break;
        case 'page':
            $res = getNbPage($pdo);
            if (!is_array($res)) {
                http_reponse_error('Une erreur s\'est produite lors de la récupération.');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                    'file' => __FILE__,
                ]);
                exit();
            }
            http_response_result($res);
            break;
        case 'get':
            $res = getSellPoint($pdo, null, null, null, null, 1);
            if (!is_array($res)) {
                http_reponse_error('Une erreur s\'est produite lors de la récupération.');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                    'file' => __FILE__,
                ]);
                exit();
            }
            http_response_result($res);
            break;
        case 'delete':
            $id = isset($_GET['id']) ? intval(cleanCodeString($_GET['id'])) : null;
            if ($id === null) {
                http_reponse_error('id cannot be null');
                exit();
            }
            $res = deleteSellPoint($pdo, $id);
            if (is_string($res)) {
                http_reponse_error('Le poitn de vente n\'a pas été suprimé');
                $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res, [
                    'file' => __FILE__,
                ]);
                exit();
            }
            http_reponse_success();
            break;
    }
    exit();
}

require './View/sell-point.php';