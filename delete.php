<?php

require __DIR__ . '/vendor/autoload.php';

use controllers\ProductsController;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");


$controller = new ProductsController();


$SKUs  = (array) json_decode(file_get_contents('php://input'));

echo $controller->deleteProducts($SKUs);


