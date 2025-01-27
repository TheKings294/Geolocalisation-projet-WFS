<?php
/**
 * @var PDO $pdo
 */
require './vendor/autoload.php';

use GuzzleHttp\Client;
use Dotenv\Dotenv;
use Symfony\Component\Stopwatch\Stopwatch;

$stopwatch = new Stopwatch();
$stopwatch->start('my-event');

$long_time = json_encode([
    ['Lundi' => [
        'ouverture' => '08:00',
        'fermeture' => '23:00',
    ]],
    ['Mardi' => [
        'ouverture' => '08:00',
        'fermeture' => '23:00',
    ]],
    ['Mercredi' => [
        'ouverture' => '08:00',
        'fermeture' => '23:00',
    ]],
    ['Jeudi' => [
        'ouverture' => '08:00',
        'fermeture' => '23:00',
    ]],
    ['Vendredi' => [
        'ouverture' => '08:00',
        'fermeture' => '00:00',
    ]],
    ['Samedi' => [
        'ouverture' => '08:00',
        'fermeture' => '00:00',
    ]],
    ['Dimanche' => [
        'ouverture' => '08:00',
        'fermeture' => '21:00',
    ]]
]);

$short_time = json_encode([
    ['Lundi' => [
        'ouverture' => '08:00',
        'fermeture' => '22:00',
    ]],
    ['Mardi' => [
        'ouverture' => '08:00',
        'fermeture' => '22:00',
    ]],
    ['Mercredi' => [
        'ouverture' => '08:00',
        'fermeture' => '22:00',
    ]],
    ['Jeudi' => [
        'ouverture' => '08:00',
        'fermeture' => '22:00',
    ]],
    ['Vendredi' => [
        'ouverture' => '08:00',
        'fermeture' => '23:00',
    ]],
    ['Samedi' => [
        'ouverture' => '08:00',
        'fermeture' => '00:00',
    ]],
    ['Dimanche' => [
        'ouverture' => 'fermer',
        'fermeture' => 'fermer',
    ]]
]);

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$client = new Client();
$faker = Faker\Factory::create('fr_FR');

try {
    $pdo = new PDO('mysql:host='.$_ENV['BDD_URL_SCRIPT'] . ';dbname=' . $_ENV['BDD_NAME'] .';port='. $_ENV['BDD_PORT_SCRIPT'],
        $_ENV['BDD_USERNAME'], $_ENV['BDD_PASSWORD']);
} catch (Exception $e) {
    $error[] = "BDD conect error : {$e->getMessage()}";
}


$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

$pdo->exec('TRUNCATE TABLE users');
$pdo->exec('TRUNCATE TABLE `groups`');
$pdo->exec('TRUNCATE TABLE sell_point');
$pdo->exec('TRUNCATE TABLE department');

$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$stmt = $pdo->prepare('INSERT INTO `groups` (name, color) VALUES (:name, :color)');
for ($i = 0; $i < 10; $i++) {
    try {
        $stmt->bindValue(':name', $faker->company());
        $stmt->bindValue(':color', $faker->hexColor());
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
}

$stmt = $pdo->prepare('INSERT INTO `users` (email, password, is_active) VALUES (:email, :password, :is_active)');

for($i = 0; $i < 50; $i++) {
    try {
        $stmt->bindValue(':email', $faker->email());
        $stmt->bindValue(':password', '$2y$10$UED/HmcickyPq6wU9zsky.my9ICaywAaT0RHcsgBvii9lNZPQWXNK');
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

$jsonDep = json_decode(file_get_contents(__DIR__ . '/departements-avec-outre-mer.geojson'));

$stmt = $pdo->prepare('INSERT INTO `department` (name, depart_num, polygon_json) VALUES (:name, :depart_num, :polygon_json)');

foreach ($jsonDep->features as $key) {
    try {
        $data = [];
        if(count($key->geometry->coordinates) > 1 && $key->geometry->type === 'Polygon') {
            foreach($key->geometry->coordinates as $coordinate) {
                array_push($data, treatAsPolygon($coordinate));
            }
        } else {
            foreach($key->geometry->coordinates as $coordinates) {
                switch($key->geometry->type) {
                    case 'MultiPolygon':
                        array_push($data, treatAsMultiPolygon($coordinates));
                        break;
                    case "Polygon":
                        $data = treatAsPolygon($coordinates);
                        break;
                }
            }
        }

        try {
            $stmt->bindValue(':name', $key->properties->nom);
            $stmt->bindValue(':depart_num', $key->properties->code);
            $stmt->bindValue(':polygon_json', json_encode($data));
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }

    } catch(Exception $e) {
        throw new Exception("Erreur sur le departement : {$key->properties->nom}\n");
    }
}

$stmte = $pdo->prepare('SELECT id , name FROM `department` WHERE `depart_num` = :departement');
$stmt = $pdo->prepare('INSERT INTO `sell_point` 
    (name, siret, address, img, manager, hourly, department_id, coordonate_x, coordonate_y, group_id) 
VALUES (:name, :siret, :address, :img, :manager, :hourly, :department,:x, :y, :group_id)');

$sellPointContent = getAddress($client);

for ($i = 1; $i < 29; $i++) {
    $line = explode(';', end($sellPointContent[$i]));
    try {
        $stmte->bindValue(':departement', $line[1]);
        $stmte->execute();
        $res = $stmte->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    $imgUrlRandom = $faker->numberBetween(1,5);
    $hourlyRandom = $faker->numberBetween(1,2);

    $name = 'Mc Donalds ' . $line[5];
    $address = $line[4];
    $imgUrl = 'mcdo'.$imgUrlRandom.'.jpg';
    $hourly = $hourlyRandom === 1 ? $long_time : $short_time;
    $departement = $res['id'];
    $group_id = $faker->numberBetween(1, 10);
    $x = $line[3];
    $y = $line[2];

    try {
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
function swapLatLng(array $data): array {
    return array_map(function ($coords) {
        return [$coords[1], $coords[0]];
    }, $data);
}

function treatAsMultiPolygon(array $multipolygon) : array {
    $data = [];
    foreach($multipolygon as $key => $polygon) {
        $data[$key] = treatAsPolygon($polygon);
    }
    return $data;
}

function treatAsPolygon(array $polygon) : array {
    $data = [];
    foreach($polygon as $key => $coordinates) {
        $data[$key] = array_reverse($coordinates);
    }
    return $data;
}
function getAddress($client)
{
  $file = __DIR__ . '/AdresseWFS.csv';

  $url = 'https://api-adresse.data.gouv.fr/search/csv/';
  try {
    $response = $client->request('POST', $url, [
      'multipart' => [
        [
          'name' => 'data',
          'contents' => fopen($file, 'r')
        ],
        [
          'name' => 'columns',
          'contents' => 'Address'
        ],
        [
          'name' => 'result_columns',
          'contents' => 'latitude'
        ],
        [
          'name' => 'result_columns',
          'contents' => 'longitude'
        ],
        [
          'name' => 'result_columns',
          'contents' => 'result_label'
        ],
        [
          'name' => 'result_columns',
          'contents' => 'result_city'
        ]
      ],
    ]);
    $csvContent = $response->getBody();
  } catch (\GuzzleHttp\Exception\RequestException $e) {
    echo $e->getMessage();
  }

  $rows = array_map(function ($line) {
    return str_getcsv($line, ',', '"', '\\');
  }, explode("\n", $csvContent));

  return $rows;
}
$event = $stopwatch->stop('my-event');

echo 'Duration: ' . $event->getDuration() . " ms\n";
echo 'Memory Usage: ' . $event->getMemory() . " bytes\n";
