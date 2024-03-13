<?php

require __DIR__ . '/vendor/autoload.php';

use controllers\ProductsController;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");


$controller = new ProductsController();

$method = $_SERVER['REQUEST_METHOD'];

if($method == "POST"){

    echo $controller->addProduct($_POST);

}
else if ($method == "GET")
{
    echo  $controller->getProducts();
}
else{

    $SKUs  = (array) json_decode(file_get_contents('php://input'));

    echo $controller->deleteProducts($SKUs);
}


