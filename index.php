<?php
    session_start();
    require 'Includes/database.php';
    require 'Includes/functions.php';
    require 'Includes/constant.php';
    require 'Includes/http-response.php';
    require 'helpers/helper-sirenne-api.php';
    require 'helpers/helper-address-api.php';
    require 'helpers/helper-commune-api.php';

    if(isset($_GET["disconect"])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
    if(!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
    ) {
        if(isset($_SESSION['auth'])) {
            if(isset($_GET["component"])){
                $componentName = cleanCodeString($_GET["component"]);
                if(file_exists("Controller/$componentName.php")){
                    require "Controller/$componentName.php";
                    exit();
                }
            } else {
                require "Controller/home.php";
                exit();
            }
        } else {
            require 'Controller/login.php';
        }
        exit();
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./Includes/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="Includes/fontawsome/css/all.min.css">
        <link rel="stylesheet" href="./Includes/leaflet/leaflet.css">
        <link rel="stylesheet" href="./assets/css/style.css">
        <link rel="icon" href="./favicon.ico">
        <title>Projet Géolocalisation</title>
    </head>
    <body data-bs-theme="dark">
        <header>
            <?php
                if(isset($_SESSION['auth'])) {
                    require './_partials/navbar.php';
                }
            ?>
        </header>
        <main>
            <div id="alert-message"></div>
            <div class="container">
                <?php
                    if(isset($_SESSION['auth'])) {
                        if(isset($_GET["component"])){
                            $componentName = cleanCodeString($_GET["component"]);
                            if(file_exists("Controller/$componentName.php")){
                                require "Controller/$componentName.php";
                            }
                        } else {
                            require "Controller/home.php";
                        }
                    } else {
                        require 'Controller/login.php';
                    }
                ?>
            </div>
        </main>
        <?php
            require './_partials/toast.html';
            require './_partials/spinner.html';
            require './_partials/modal.html';
        ?>
        <script src="Includes/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="Includes/leaflet/leaflet.js"></script>
        <script src="Includes/autoComplete.js-10.2.9/autoComplete.js"></script>
    </body>
</html>