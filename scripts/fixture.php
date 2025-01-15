<?php
/**
 * @var PDO $pdo
 */
require './vendor/autoload.php';

$long_time = json_encode([
    'Lundi' => [
        'ouverture' => '08:00',
        'fermeture' => '23:00',
    ],
    'Mardi' => [
        'ouverture' => '08:00',
        'fermeture' => '23:00',
    ],
    'Mercredi' => [
        'ouverture' => '08:00',
        'fermeture' => '23:00',
    ],
    'Jeudi' => [
        'ouverture' => '08:00',
        'fermeture' => '23:00',
    ],
    'Vendredi' => [
        'ouverture' => '08:00',
        'fermeture' => '00:00',
    ],
    'Samedi' => [
        'ouverture' => '08:00',
        'fermeture' => '00:00',
    ],
    'Dimanche' => [
        'ouverture' => '08:00',
        'fermeture' => '21:00',
    ]

]);

$short_time = json_encode([
    'Lundi' => [
        'ouverture' => '08:00',
        'fermeture' => '22:00',
    ],
    'Mardi' => [
        'ouverture' => '08:00',
        'fermeture' => '22:00',
    ],
    'Mercredi' => [
        'ouverture' => '08:00',
        'fermeture' => '22:00',
    ],
    'Jeudi' => [
        'ouverture' => '08:00',
        'fermeture' => '22:00',
    ],
    'Vendredi' => [
        'ouverture' => '08:00',
        'fermeture' => '23:00',
    ],
    'Samedi' => [
        'ouverture' => '08:00',
        'fermeture' => '00:00',
    ],
    'Dimanche' => [
        'ouverture' => 'fermer',
        'fermeture' => 'fermer',
    ]
]);

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $pdo = new PDO('mysql:host='.$_ENV['BDD_URL_SCRIPT'] . ';dbname=geoloc_projet;port='. $_ENV['BDD_PORT_SCRIPT'],
        $_ENV['BDD_USERNAME'], $_ENV['BDD_PASSWORD']);
} catch (Exception $e) {
    $error[] = "BDD conect error : {$e->getMessage()}";
}

use GuzzleHttp\Client;
$client = new Client();

$faker = Faker\Factory::create('fr_FR');

for ($i = 0; $i < 10; $i++) {
    try {
        $stmt = $pdo->prepare('INSERT INTO `groups` (name) VALUES (:name)');
        $stmt->bindValue(':name', $faker->company());
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
}

for($i = 0; $i < 50; $i++) {
    try {
        $stmt = $pdo->prepare('INSERT INTO `users` (email, password, is_active) VALUES (:email, :password, :is_active)');
        $stmt->bindValue(':email', $faker->email());
        $stmt->bindValue(':password', password_hash($faker->password(), PASSWORD_DEFAULT));
        $stmt->bindValue(':is_active', $faker->numberBetween(0, 1), PDO::PARAM_BOOL);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
}
try {
    $stmt = $pdo->prepare('INSERT INTO `users` (email, password, is_active) VALUES (:email, :password, :is_active)');
    $stmt->bindValue(':email', 'admin@admin.com');
    $stmt->bindValue(':password', password_hash('admin', PASSWORD_DEFAULT));
    $stmt->bindValue(':is_active', 1, PDO::PARAM_BOOL);
    $stmt->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

for ($i = 0; $i < 30; $i++) {
    $adresse = $faker->streetAddress();
    $adresse = str_replace(" ", "+", $adresse);

    $apiAddress = 'https://api-adresse.data.gouv.fr/search/?q='.$adresse.'&limit=1';

    try {
        $response = $client->request('GET', $apiAddress);
        $data = json_decode($response->getBody(), true);
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        echo "Erreur lors de l'appel API : " . $e->getMessage();
        exit();
    }

    $apiComune = 'https://geo.api.gouv.fr/communes?code='. $data['features']['0']['properties']['citycode'] . '&fields=departement';

    try {
        $response = $client->request('GET', $apiComune);
        $datas = json_decode($response->getBody(), true);
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        echo "Erreur lors de l'appel API : " . $e->getMessage();
        exit();
    }

    $imgUrlRandom = $faker->numberBetween(1,5);
    $hourlyRandom = $faker->numberBetween(1,2);

    $name = 'Mc Donalds ' . $data['features']['0']['properties']['city'];
    $address = $data['features']['0']['properties']['label'];
    $imgUrl = 'mcdo'.$imgUrlRandom.'.jpg';
    $hourly = $hourlyRandom === 1 ? $long_time : $short_time;
    if(!isset($datas['0']['departement']['code'])) {
        $departement = substr($data['features']['0']['properties']['postcode'], -3, 2);
    } else {
        $departement = $datas['0']['departement']['code'];
    }
    $group_id = $faker->numberBetween(1, 10);
    $x = $data['features']['0']['geometry']['coordinates'][0];
    $y = $data['features']['0']['geometry']['coordinates'][1];

    try {
        $stmt = $pdo->prepare('INSERT INTO `sell_point` (name, siret, address, img, manager, hourly, department, coordonate_x, coordonate_y, group_id) 
VALUES (:name, :siret, :address, :img, :manager, :hourly, :department,:x, :y, :group_id)');
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':siret', $faker->siret());
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':img', $imgUrl);
        $stmt->bindValue(':manager', $faker->name());
        $stmt->bindValue(':hourly', $hourly);
        $stmt->bindValue(':department', $departement);
        $stmt->bindValue(':x', $x);
        $stmt->bindValue(':y', $y);
        $stmt->bindValue(':group_id', $group_id);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
}
