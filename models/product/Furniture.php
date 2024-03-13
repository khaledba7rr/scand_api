<?php 

namespace models\product;

class Furniture extends Product {

    function __construct()
    {
        $this->type = "Dimensions";
        $this->measurement ="";
    }

    public function setSUK(string $SUK) { $this->SUK = $SUK; } 
    
    public function setName(string $name){ $this->name = $name; }
    
    public function setPrice(float $price){ $this->price = $price; }
    
    public function setValue(string $value){ $this->value = $value; }
    
    public function getSUK(){ return $this->SUK; }
    
    public function getName(){ return $this->name; }
    
    public function getPrice(){ return $this->price; }
    
    public function getType(){ return $this->type; }
    
    public function getValue(){ return $this->value; }

    public function getMeasurement() {return $this->measurement;}

    }