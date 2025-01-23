<?php
/**
 * @var PDO $pdo
*/
require './Model/form-sell-point.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if(isset($_GET['action'])) {
        switch($_GET['action']) {
            case 'get':
                $id = isset($_GET['id']) ? cleanCodeString($_GET['id']) : null;
                if($id === null) {
                    http_reponse_error('id not found !');
                    exit();
                }
                $res = getSellPoint($pdo, $id);
                if(is_string($res)) {
                    http_reponse_error($res);
                    exit();
                }
                http_response_result($res);
                break;
            case 'new':
                $name = isset($_POST['name']) ? cleanCodeString($_POST['name']) : null;
                $managerName = isset($_POST['managerName']) ? cleanCodeString($_POST['managerName']) : null;
                $siret = isset($_POST['siret']) ? cleanCodeString($_POST['siret']) : null;
                $group = !empty($_POST['group']) ? intval(cleanCodeString($_POST['group'])) : null;
                $address = isset($_POST['address']) ? cleanCodeString($_POST['address']) : null;
                $coorX = isset($_POST['coor-x']) ? cleanCodeString($_POST['coor-x']) : null;
                $coorY = isset($_POST['coor-y']) ? cleanCodeString($_POST['coor-y']) : null;
                $jsonTime = isset($_POST['time']) ? $_POST['time'] : null;
                $department = isset($_POST['department']) ? cleanCodeString($_POST['department']) : null;

                for($i = 0; $i <= 13; $i++) {
                    $times["time". $i] = isset($_POST['time'.$i]) ? cleanCodeString($_POST['time'.$i]) : null;
                }

                if ($name !== null && $managerName !== null && $siret !== null &&
                    $address !== null && $coorX !== null && $coorY !== null && $jsonTime !== null) {

                    if(empty($_FILES['image']['name'])) {
                        http_reponse_error('Image Required');
                        exit();
                    }
                    $finalFileName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    mooveFile($_FILES['image']['tmp_name'], $finalFileName);

                    $depId = getDepartement($pdo, $department);
                    if(is_string($depId)) {
                        http_reponse_error($depId);
                        exit();
                    }
                    $department = $depId['id'];

                    $res = setNewSellPoint($pdo, $name, $siret, $address, $finalFileName, $managerName, $jsonTime, $department, $coorX, $coorY, $group);

                    if(is_string($res)) {
                        http_reponse_error($res);
                        exit();
                    }
                   http_reponse_success();
                } else {
                    http_reponse_error('Formulaire incorrect');
                    exit();
                }
                break;
            case 'edit':
                $name = isset($_POST['name']) ? cleanCodeString($_POST['name']) : null;
                $managerName = isset($_POST['managerName']) ? cleanCodeString($_POST['managerName']) : null;
                $siret = isset($_POST['siret']) ? cleanCodeString($_POST['siret']) : null;
                $group = !empty($_POST['group']) ? intval(cleanCodeString($_POST['group'])) : null;
                $address = isset($_POST['address']) ? cleanCodeString($_POST['address']) : null;
                $coorX = isset($_POST['coor-x']) ? cleanCodeString($_POST['coor-x']) : null;
                $coorY = isset($_POST['coor-y']) ? cleanCodeString($_POST['coor-y']) : null;
                $department = isset($_POST['department']) ? cleanCodeString($_POST['department']) : null;
                $jsonTime = isset($_POST['time']) ? $_POST['time'] : null;
                $id = isset($_GET['id']) ? cleanCodeString($_GET['id']) : null;
                $times = [];

                for($i = 0; $i <= 13; $i++) {
                    $times["time". $i] = isset($_POST['time'.$i]) ? cleanCodeString($_POST['time'.$i]) : null;
                }
                $res = verifImage($pdo, $id);
                if($res['img'] === null && empty($_FILES['image']['name'])) {
                    http_reponse_error('Image Required');
                    exit();
                }
                if($res['img'] !== null && !empty($_FILES['image']['name'])) {
                    $delet = deletImage($pdo, $id);
                    if(is_string($delet)) {
                        http_reponse_error($res);
                        exit();
                    }
                    $res = deletFile($res['img']);
                    if($res === false) {
                        http_reponse_error('Image could not be deleted');
                        exit();
                    }
                }
                if ($name !== null && $managerName !== null && $siret !== null &&
                    $address !== null && $coorX !== null && $coorY !== null && $jsonTime !== null) {

                    if(!empty($_FILES['image']['name'])) {
                        $finalFileName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        mooveFile($_FILES['image']['name'], $finalFileName);
                    }

                    if(!isset($finalFileName)) {
                        $finalFileName = null;
                    }
                    $depId = getDepartement($pdo, $department);
                    if(is_string($depId)) {
                        http_reponse_error($depId);
                        exit();
                    }
                    $department = $depId['id'];

                    $res = updateSellPoint($pdo, $id, $name, $siret, $address, $finalFileName, $managerName, $jsonTime, $department, $coorX, $coorY, $group);
                    if(is_string($res)) {
                        http_reponse_error($res);
                        exit();
                    }
                    http_reponse_success();
                }
                break;
        }
        exit();
    }
}

require './View/form-sell-point.php';