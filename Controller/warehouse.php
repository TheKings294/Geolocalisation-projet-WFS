<?php
require './Model/warehouse.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WIDTH']) &&
    $_SERVER['HTTP_X_REQUESTED_WIDTH'] === 'XMLHttpRequest'
) {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'get':
                
                break;
        }
    }
}

require './View/warehouse.php';