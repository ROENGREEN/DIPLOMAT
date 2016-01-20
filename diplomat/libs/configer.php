<?php

class Configer implements ArrayAccess, Countable, IteratorAggregate {
    protected static $_instance = null;
    protected static $_configFile = '';
    protected $_values = array();
    
    public static function getInstance() {
        if (self::$_instance === null) {
            $c = __CLASS__;
            self::$_instance = new $c;
        } 
        
        return self::$_instance;
    }    
   
    public function setFile($filePath) {     
        if (self::$_instance !== null) {
            throw new Exception('You need to set the path before calling '. __CLASS__ .'::getInstance() method', 0);
        } else {
            self::$_configFile = $filePath;
        }
    }

    protected function __construct() {        
        $values = @include( self::$_configFile );
        if (is_array($values)) {
            $this->_values = &$values;
        }
    }    
   
    final protected function __clone() {
    }    
    
    public function count() {
        return sizeof($this->_values);
    }     
  
    public function offsetExists($offset) {
        return key_exists($offset, $this->_values);
    }    
    
    public function offsetGet($offset) {
        return $this->_values[$offset];
    }
    
    public function offsetSet($offset, $value) {
        $this->_values[$offset] = $value;
    } 
    
    public function offsetUnset($offset) {
        unset($this->_values[$offset]);
    }    
    
    public function getIterator() {
        return new ArrayIterator($this->_values);
    }    
    
    public function __set($key, $value) {
        $this->_values[$key] = $value;
    }    
   
    public function __get($key) {
        return $this->_values[$key];
    }
    
}