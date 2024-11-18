<?php
class Car{
    private $color;
    private $model;

    public function __construct($color, $model){
        $this->color = $color;
        $this->model = $model;
    }

    public function getModel(){
        return $this->model;
    }

    public function getColor(){
        return $this->color;
    }

    public function setColor($color){
        $this->color = $color;
    }
}

$car = new Car("Blue", "Toyota");
echo $car->getModel() . "<br>";
echo $car->getColor() . "<br>";
$car->setColor("Red");
echo "Update Color: " . $car->getColor();