<?php 

namespace factories;

use models\product\Book;

 class BookFactory extends Factory{

    public static function createObject(){
        return new Book();
    }
}