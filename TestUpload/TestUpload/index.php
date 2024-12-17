<?php

require_once 'config.php';
require_once 'controllers/PrestasiController.php';
// require_once 'controllers/HomeController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'prestasi';

switch ($page) {
    case 'prestasi':
        $controller = new PrestasiController($conn);
        $controller->handlePostRequest();  
        $controller->showForm(); 
        break;

    default:
        echo "Halaman tidak ditemukan.";
        break;
}
