<?php
class Data {
    private $firstField;
    private $secondField;
    
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    
    public function __set($property, $value) {
        //if (property_exists($this, $property)) {
            $this->$property = $value;
        //}
        return $this;
    }
    
    public function __unset($property){
        if (property_exists($this, $property)) {
            unset($this->$property);
        }
    }
}
?>