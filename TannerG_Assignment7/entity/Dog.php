<?php

class Dog implements JsonSerializable {
    private $dogID;
    private $dogName;
    private $dogAge;
    private $dogBreed;
    private $trained;
    
    public function __construct($dogID, $dogName, $dogAge, $dogBreed, $trained) {
        $this->dogID = $dogID;
        $this->dogName = $dogName;
        $this->dogAge = $dogAge;
        $this->dogBreed = $dogBreed;
        $this->trained = $trained;
    }

    public function getDogID() {
        return $this->dogID;
    }

    public function getDogName() {
        return $this->dogName;
    }

    public function getDogAge() {
        return $this->dogAge;
    }

    public function getDogBreed() {
        return $this->dogBreed;
    }

    public function getTrained() {
        return $this->trained;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
// end class Dog