<?php 
include 'Animal.php';
class Cat extends Animal {
    public function meow() {
        echo $this->name . " is meowing. <br>";
    }
}

class Dog extends Animal {
    public function bark() {
        echo $this->name . " is barking. <br>";
    }
}

$cat = new Cat("Whiskers");
$dog = new Dog("Buddy");

$cat->eat();
$dog->sleep();

$cat->meow();
$dog->bark();
?>