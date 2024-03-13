<?php

namespace controllers;

use Exception;
use models\dbcontext\ProductsDbContext;

use factories\BookFactory;
use factories\DvdFactory;
use factories\FurnitureFactory;


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

class ProductsController {
    private $conn;
    private $productsFactory;
    private $tableName = "products";

    public function __construct(){

         $this->productsFactory = [
            'dvd' => DvdFactory::createObject(),
            'Size' => DvdFactory::createObject(),
            'furniture' => FurnitureFactory::createObject(),
            'Dimensions' => FurnitureFactory::createObject(),
            'book' =>  BookFactory::createObject(),
            'Weight' => BookFactory::createObject(),
        ];

        $database = new ProductsDbContext();

        $this->conn = $database->conn;
    }

    public function __destruct() {

    }

    private function insertQuery($product) : string
    {
        // $keys = implode(',', array_keys($productsData) );
        // $values = implode(',', array_values($productsData) );

        return "INSERT INTO {$this->tableName} (`SKU`, `name`, `price`, `type`, `value`)" .
        " VALUES (\"{$product->getSUK()}\", \"{$product->getName()}\", \"{$product->getPrice()}\", \"{$product->getType()}\", \"{$product->getValue()}\")";
    }

    public function addProduct ($data){

        $skuExists = $this->getProductBy($data["SKU"]);

        if($skuExists){

            $response = ['code' => 0, 'message' => 'Product with the same SKU exists. SKU should be unique for each product'];

            http_response_code(200);

            return json_encode($response);
        }

        $product = $this->productsFactory[$data["type"]];

        $product->setSUK($data["SKU"]);
        $product->setName($data["name"]);
        $product->setPrice($data["price"]);
        $product->setValue($data["value"]);

        $query = $this->insertQuery($product);

        try{

            $result = $this->conn->query($query);

            if($result){
                http_response_code(200);

                $response = ['code' => 1];

                return json_encode($response);
            }else{

                $response = ['code' => 0, 'message' => 'Couldn\'t get prodcts, unspecified error !'];

                 return json_encode($response);
            }

         }
         catch(Exception $exc){

            $response = ['code' => 0, 'message' => 'Couldn\'t get prodcts, unspecified error !'];

            return json_encode($response);
         }
    }

    public function getProducts(){

        $productsQuery = "SELECT * FROM {$this->tableName}";

        try{

            $result = $this->conn->query($productsQuery);

            if($result){

                http_response_code(200);

                $productList = array();

                while ($row = mysqli_fetch_assoc($result)) {
                    $productType = $this->productsFactory[$row['type']];

                    $productType->setSUK($row["SKU"]);
                    $productType->setName($row["name"]);
                    $productType->setPrice($row["price"]);
                    $productType->setValue($row["value"]);

                    $productList[] = ['SKU' => $productType->getSUK(), 'name' => $productType->getName(),'price' => $productType->getPrice(),
                                      'value' => $productType->getValue() . $productType->getMeasurement(),'type' => $productType->getType() ];
                }

                return json_encode($productList);

            }
            else{
                http_response_code(400);

                $response = ['code' => 0, 'message' => 'Couldn\'t get prodcts, unspecified error !'];

                return json_encode($response);
            }

         }
         catch(Exception $exc){
            http_response_code(400);

            $response = ['code' => 0, 'message' => 'Couldn\'t get prodcts, unspecified error !'];

            print json_encode($response);
         }

    }

    public function deleteProducts(array $SKUs){

        $SKUsKeysStatement = json_encode($SKUs);
        $SKUsKeysStatement = str_replace("[", "", $SKUsKeysStatement);
        $SKUsKeysStatement = str_replace("]", "", $SKUsKeysStatement);
        $SKUsKeysStatement = explode(",", $SKUsKeysStatement);
        
        $SKUsKeysStatement = implode(" OR SKU = ", array_values($SKUsKeysStatement));

        $sqlQuery = "DELETE FROM {$this->tableName} WHERE SKU = " . $SKUsKeysStatement;

       $result = $this->conn->query($sqlQuery);

       if($result){
            http_response_code(200);

            $response = ['code' => 1];

            print json_encode($response);
       }else{
            http_response_code(400);

            $response = ['code' => 0, 'message' => 'Couldn\'t delete, unspecified problem !'];

            print json_encode($response);
       }
    }

    public function getProductBy(string $SKU){

        $productWithSameSKU = "SELECT * FROM products WHERE SKU = \"$SKU\" ";

        $result = $this->conn->query($productWithSameSKU);

        if($result->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }
}