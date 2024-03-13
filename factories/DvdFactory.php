<?php 

namespace factories;

use models\product\DVD;

 class DvdFactory extends Factory{

    public static function createObject(){
        return new DVD();
    }
}