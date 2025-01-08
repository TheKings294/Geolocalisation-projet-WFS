<?php
    session_start();
    require 'Includes/database.php';
    require 'Includes/functions.php';

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
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous">
        <link
                rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
                integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
                crossorigin="anonymous"
                referrerpolicy="no-referrer" />
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
            require './_partials/spinner.html';exit();
        ?>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous">
        </script>
    </body>
</html>