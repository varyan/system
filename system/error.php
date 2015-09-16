<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class Error extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function method_missed($controller,$method){
        $this->args = ['message'   =>'The <b>'.$controller.'</b> controller dose`nt have <b>'.$method.'</b> method'];
        if(!file_exists(VIEW_PATH.'error/method'.EXT)){
            show_error('method');
        }
        $this->view('error/method',$this->args);
    }

    public function page_not_found(){

    }
}