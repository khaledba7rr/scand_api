<?php 

namespace factories;

use models\product\Furniture;

 class FurnitureFactory extends Factory{

    public static function createObject(){
        return new Furniture();
    }
}