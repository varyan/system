<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class Model{
    /*
    *---------------------------------------------------------------
    * $table variable
    *---------------------------------------------------------------
    */
    private $table;
    /*
    *---------------------------------------------------------------
    * __construct method
    * @param boolean/string $table (default false)
    *---------------------------------------------------------------
    */
    public function __construct($table = false){
        if($table !== false) $this->table = $table;
    }
    /*
    *---------------------------------------------------------------
    * select method
    *---------------------------------------------------------------
    */
    public function select(){

    }
    /*
    *---------------------------------------------------------------
    * insert method
    *---------------------------------------------------------------
    */
    public function insert(){

    }
    /*
    *---------------------------------------------------------------
    * update method
    *---------------------------------------------------------------
    */
    public function update(){

    }
    /*
    *---------------------------------------------------------------
    * delete method
    *---------------------------------------------------------------
    */
    public function delete(){

    }
}