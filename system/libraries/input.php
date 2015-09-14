<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class Input {
    private $data;
    /**
     * Constructor
     * */
    public function __construct(){}
    /**
     * Form get method
     *
     * @var string $field
     * @return get data
     * */
    public function get($filed){
        if(isset($_GET[$filed])){
            $this->data = $_GET[$filed];
            $this->data = trim(stripcslashes(htmlspecialchars($this->data)));
            return $this->data;
        }
        return null;
    }
    /**
     * Form post method
     *
     * @var boolean/string $field
     * @return null/array
     * */
    public function post($filed = false){
        if(!$filed){return $_POST;}
        if(isset($_POST[$filed])){
            $this->data = $_POST[$filed];
            $this->data = trim(stripcslashes(htmlspecialchars($this->data)));
            return $this->data;
        }
        return null;
    }
    /**
     * Form request method
     *
     * @var string $field
     * @return request data
     * */
    public function request($filed){
        if(isset($_REQUEST[$filed])){
            $this->data = $_REQUEST[$filed];
            $this->data = trim(stripcslashes(htmlspecialchars($this->data)));
            return $this->data;
        }
        return null;
    }
    /**
     * Destructor
     * */
    public function __destruct(){
        unset($this);
    }
}