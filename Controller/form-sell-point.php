<?php
/**
 * @var PDO $pdo
 * @var object $appLogger
 * @var object $apiLogger
*/
require './Model/form-sell-point.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if (isset($_GET['action'])) {
        switch($_GET['action']) {
            case 'get':
                $id = isset($_GET['id']) ? cleanCodeString($_GET['id']) : null;
                if ($id === null) {
                    http_reponse_error('id not found !');
                    exit();
                }
                $res = getSellPoint($pdo, $id);
                if (is_string($res)) {
                    http_reponse_error('Impossible to get sell point !');
                    $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res);
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

                if ($name !== null && $managerName !== null && $siret !== null &&
                    $address !== null && $coorX !== null && $coorY !== null && $jsonTime !== null && $department !== null) {

                    if (empty($_FILES['image']['name'])) {
                        http_reponse_error('Image Required');
                        exit();
                    }
                    $finalFileName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $res = mooveFile($_FILES['image']['tmp_name'], $finalFileName);

                    if (is_string($res)) {
                        http_reponse_error('Impossible to move sell point image !');
                        $appLogger->error('[' .$_SESSION['username'] . ']' . ' ' . $res);
                        exit();
                    }

                    $depId = getDepartement($pdo, $department);
                    if (is_string($depId)) {
                        http_reponse_error('Oups ... le service ne réponds pas !');
                        $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $depId);
                        exit();
                    }
                    $department = $depId['id'];

                    $res = setNewSellPoint($pdo, $name, $siret, $address, $finalFileName, $managerName, $jsonTime, $department, $coorX, $coorY, $group);

                    if (is_string($res)) {
                        http_reponse_error('Le point de vente na pas pu être crée');
                        $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res);
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

                $res = verifImage($pdo, $id);
                if ($res['img'] === null && empty($_FILES['image']['name'])) {
                    http_reponse_error('Image Required');
                    exit();
                }
                if ($res['img'] !== null && !empty($_FILES['image']['name'])) {
                    $delet = deletImage($pdo, $id);
                    if(is_string($delet)) {
                        http_reponse_error($res);
                        $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res);
                        exit();
                    }
                    $res = deletFile($res['img']);
                    if($res === false) {
                        http_reponse_error('Image could not be deleted');
                        $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res);
                        exit();
                    }
                }
                if ($name !== null && $managerName !== null && $siret !== null &&
                    $address !== null && $coorX !== null && $coorY !== null && $jsonTime !== null && $department !== null) {

                    if (!empty($_FILES['image']['name'])) {
                        $finalFileName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        $res = mooveFile($_FILES['image']['tmp_name'], $finalFileName);
                        if (is_string($res)) {
                            http_reponse_error('Image can not be uploaded');
                            $appLogger->error('[' .$_SESSION['username'] . ']' . ' ' . $res);
                            exit();
                        }
                    }

                    if (!isset($finalFileName)) {
                        $finalFileName = null;
                    }
                    $depId = getDepartement($pdo, $department);
                    if (is_string($depId)) {
                        http_reponse_error('LE département n a pas pu être récupéré');
                        $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $depId);
                        exit();
                    }
                    $department = $depId['id'];

                    $res = updateSellPoint($pdo, $id, $name, $siret, $address, $finalFileName, $managerName, $jsonTime, $department, $coorX, $coorY, $group);
                    if (is_string($res)) {
                        http_reponse_error('Le point de vente n a pas pu être éditer');
                        $appLogger->critical('[' .$_SESSION['username'] . ']' . ' ' . $res);
                        exit();
                    }
                    http_reponse_success();
                }
                break;
            case 'insee-api':
                $siretNumber = isset($_GET['siret']) ? cleanCodeString($_GET['siret']) : null;
                if (empty($siretNumber)) {
                    http_reponse_error('Siret Number Required');
                    exit();
                }
                $res = sirenne_api(URL_SIRET, $_ENV['SIRENE_API_KEY'], $siretNumber);
                if (is_string($res)) {
                    http_reponse_error('SIRET Number Error');
                    $apiLogger->error('[' .$_SESSION['username'] . ']' . ' ' . $res);
                    exit();
                }
                $codePostal = commune_api($res['etablissement']['adresseEtablissement']['codePostalEtablissement']);
                if (is_string($codePostal)) {
                    http_reponse_error('Postal Code Error');
                    $apiLogger->error('[' .$_SESSION['username'] . ']' . ' ' . $codePostal);
                    exit();
                }
                $latPoint = convertOrdoToLat($res['etablissement']['adresseEtablissement']['coordonneeLambertAbscisseEtablissement'],
                    $res['etablissement']['adresseEtablissement']['coordonneeLambertOrdonneeEtablissement']);
                $jsonResponse = json_encode([
                    'address' => $res['etablissement']['adresseEtablissement']['numeroVoieEtablissement'] . ' ' .
                        $res['etablissement']['adresseEtablissement']['typeVoieEtablissement'] . ' ' .
                        $res['etablissement']['adresseEtablissement']['libelleVoieEtablissement'] . ' ' .
                        $res['etablissement']['adresseEtablissement']['codePostalEtablissement'] . ' ' .
                        $res['etablissement']['adresseEtablissement']['libelleCommuneEtablissement'] ,
                    'siret' => $res['etablissement']['siret'],
                    'departement' => $codePostal[0]['departement']['code'],
                    'coorX' => $latPoint[0],
                    'coorY' => $latPoint[1],
                ]);
                http_response_result($jsonResponse);
                break;
            case 'address-communes-api':
                $address = !empty($_GET['text']) ? cleanCodeString($_GET['text']) : null;
                if ($address === null) {
                    http_reponse_error('Address is required');
                    exit();
                }
                $addressResponse = address_api($address);
                if (is_string($addressResponse)) {
                    http_reponse_error('Oups ... le service ne réponds pas');
                    $apiLogger->error('[' .$_SESSION['username'] . ']' . ' ' . $address);
                    exit();
                }
                $departmentCode = commune_api($addressResponse['features'][0]['properties']['postcode']);
                if (is_string($departmentCode)) {
                    http_reponse_error('Oups ... le service ne réponds pas');
                    $apiLogger->error('[' .$_SESSION['username'] . ']' . ' ' . $departmentCode);
                    exit();
                }
                http_response_result(['address' => $addressResponse['features'][0]['properties']['label'],
                    'x' => $addressResponse['features'][0]['geometry']['coordinates'][0],
                    'y' => $addressResponse['features'][0]['geometry']['coordinates'][1],
                    'dep' => $departmentCode[0]['departement']['code']]);
                break;
        }
        exit();
    }
}

require './View/form-sell-point.php';