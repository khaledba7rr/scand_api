<?php

namespace models\product;

 abstract class Product {
   
    protected string $SUK;
    protected string $name;
    protected float $price;
    protected string $type;
    protected string $value;
    protected string $measurement;

    abstract public function setSUK(string $SUK);
    abstract public function setName(string $name);
    abstract public function setPrice(float $price);
    abstract public function setValue(string $value);

    abstract public function getSUK();
    abstract public function getName();
    abstract public function getType();
    abstract public function getPrice();
    abstract public function getValue();
    abstract public function getMeasurement();

 }


