<?php
interface shape{
    public function calculateArea();
}

interface color{
    public function getColor();
}

class circle implements shape, color{
    private $radius;
    private $color;

    public function __construct($radius, $color){
        $this->radius = $radius;
        $this->color = $color;
    }

    public function calculateArea(){
        return pi()* pow($this->radius, 2);
    }

    public function getColor(){
        return $this->color;
    }    
}
$circle = new circle(5, "Blue");
echo "Area Circle: " . $circle->calculateArea() . "<br>";
echo "Color Circle: " . $circle->getColor();
?>