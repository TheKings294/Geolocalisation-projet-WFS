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
                $department = isset($_POST['department']) ? cleanCodeString($_POST['department']) : null;
                $times = [];

                for($i = 0; $i <= 13; $i++) {
                    $times["time". $i] = isset($_POST['time'.$i]) ? cleanCodeString($_POST['time'.$i]) : null;
                }

                if ($name !== null && $managerName !== null && $siret !== null &&
                    $address !== null && $coorX !== null && $coorY !== null && $times['time0'] !== null) {

                    if(empty($_FILES['image']['name'])) {
                        http_reponse_error('Image Required');
                        exit();
                    }
                    $finalFileName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    mooveFile($_FILES['image']['tmp_name'], $finalFileName);

                    $jsonTime = json_encode([
                        'Lundi' => [
                            'ouverture' => $times['time0'],
                            'fermeture' => $times['time1'],
                        ],
                        'Mardi' => [
                            'ouverture' => $times['time2'],
                            'fermeture' => $times['time3'],
                        ],
                        'Mercredi' => [
                            'ouverture' => $times['time4'],
                            'fermeture' => $times['time5'],
                        ],
                        'Jeudi' => [
                            'ouverture' => $times['time6'],
                            'fermeture' => $times['time7'],
                        ],
                        'Vendredi' => [
                            'ouverture' => $times['time8'],
                            'fermeture' => $times['time9'],
                        ],
                        'Samedi' => [
                            'ouverture' => $times['time10'],
                            'fermeture' => $times['time11'],
                        ],
                        'Dimanche' => [
                            'ouverture' => $times['time12'] !== "" ? $times['time12'] : "fermé",
                            'fermeture' => $times['time13'] !== "" ? $times['time13'] : "fermé",
                            ]]
                    );

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
                    $res = deletFile($res['img']);
                }
                if ($name !== null && $managerName !== null && $siret !== null &&
                    $address !== null && $coorX !== null && $coorY !== null && $times['time0'] !== null) {

                    if(!empty($_FILES['image']['name'])) {
                        $finalFileName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        mooveFile($_FILES['image']['name'], $finalFileName);
                    }

                    $jsonTime = json_encode([
                            'Lundi' => [
                                'ouverture' => $times['time0'],
                                'fermeture' => $times['time1'],
                            ],
                            'Mardi' => [
                                'ouverture' => $times['time2'],
                                'fermeture' => $times['time3'],
                            ],
                            'Mercredi' => [
                                'ouverture' => $times['time4'],
                                'fermeture' => $times['time5'],
                            ],
                            'Jeudi' => [
                                'ouverture' => $times['time6'],
                                'fermeture' => $times['time7'],
                            ],
                            'Vendredi' => [
                                'ouverture' => $times['time8'],
                                'fermeture' => $times['time9'],
                            ],
                            'Samedi' => [
                                'ouverture' => $times['time10'],
                                'fermeture' => $times['time11'],
                            ],
                            'Dimanche' => [
                                'ouverture' => $times['time12'] !== "" ? $times['time12'] : "fermé",
                                'fermeture' => $times['time13'] !== "" ? $times['time13'] : "fermé",
                            ]]
                    );
                    if(!isset($finalFileName)) {
                        $finalFileName = null;
                    }
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