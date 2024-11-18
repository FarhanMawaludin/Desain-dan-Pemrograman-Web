<?php
class Animal{
    public $name;
    protected $age;
    private $color;
    
    public function __construct($name, $age, $color){
        $this->name = $name;
        $this->age = $age;
        $this->color = $color;
    }

    public function getName(){
        return $this->name;
    }

    public function getAge(){
        return $this->age;
    }

    public function getColor(){
        return $this->color;
    }
}

$animal = new Animal("Dog", 3, "Brown");
echo "name: " . $animal->getName() . "<br>";
echo "age: " . $animal->getAge() . "<br>";
echo "color: " . $animal->getColor() . "<br>";