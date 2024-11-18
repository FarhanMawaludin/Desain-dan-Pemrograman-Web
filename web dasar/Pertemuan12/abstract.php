<?php
abstract class  shape{
    abstract public function calculateArea();
}

class circle extends shape{
    public $radius;
    public function __construct($radius){
        $this->radius = $radius;
    }
    public function calculateArea(){
        return pi()* pow($this->radius, 2);
    }
}

class rectangle extends shape{
    public $width;
    public $height;
    public function __construct($width, $height){
        $this->width = $width;
        $this->height = $height;
    }
    public function calculateArea(){
        return $this->width * $this->height;
    }
}

$circle = new circle(5);
$rectangle = new rectangle(4, 6);

echo "Area Circle: " . $circle->calculateArea() . "<br>";
echo "Area Rectangle: " . $rectangle->calculateArea();