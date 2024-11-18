<?php
interface shape{
    public function calculateArea();
}

class circle implements shape{
    private $radius;
    public function __construct($radius){
        $this->radius = $radius;
    }
    public function calculateArea(){
        return pi()* pow($this->radius, 2);
    }
}

class rectangle implements shape{
    private $width;
    private $height;
    public function __construct($width, $height){
        $this->width = $width;
        $this->height = $height;
    }
    public function calculateArea(){
        return $this->width * $this->height;
    }
}

function printArea(shape $shape){
    echo "Area: " . $shape->calculateArea() . "<br>";   
}

$circle = new circle(5);
$rectangle = new rectangle(4, 10);
printArea($circle);
printArea($rectangle);
?>