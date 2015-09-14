<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class Error extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->args = ['message'=>'Page not found'];
        $this->view('error/404',$this->args);
    }
}