<?php
defined('SYS_PATH') OR exit('No direct script access allowed');


class User_model extends Model{
    /*
     *---------------------------------------------------------------
     * _constructor method
     *---------------------------------------------------------------
     */
    public function __construct(){
        parent::__construct('users');
    }
}