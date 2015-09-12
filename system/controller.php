<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class Controller{
    /*
    *---------------------------------------------------------------
    * array variable $args (default value [])
    *---------------------------------------------------------------
    */
    protected $args = [];
    /*
    *---------------------------------------------------------------
    * __construct method
    *---------------------------------------------------------------
    */
    public function __construct(){

    }
    /*
     *---------------------------------------------------------------
     * json method
     * @param array $data
     * @param string $status (default success)
     * @param string $message (default Successful result)
     *---------------------------------------------------------------
     */
    protected function json($data = array(), $status = "success", $message = "Successful result"){
        return json_encode([
            'response'  =>$data,
            'status'    =>$status,
            'message'   =>$message,
        ]);
    }
    /*
    *---------------------------------------------------------------
    * request_method method
    *---------------------------------------------------------------
    */
    protected function request_method(){
        return $_SERVER['REQUEST_METHOD'];
    }
    /*
    *---------------------------------------------------------------
    * request_is method
    * @param string $request
    *---------------------------------------------------------------
    */
    protected function request_is($request = 'GET'){
        return (strtoupper($request) === $_SERVER['REQUEST_METHOD']) ? true : false;
    }
    /*
    *---------------------------------------------------------------
    * view method
    *---------------------------------------------------------------
    */
    protected function view($file,$args = []){
        $view = APP_PATH.'views/'.$file.EXT;
        if(file_exists($view)){
            if(!is_null($args)) {
                extract($args);
            }
            require_once $view;
        }else{
            exit('The file <b>'.$file.'</b> dose`nt exists in your <b>'.APP_PATH.'views</b> folder');
        }
    }
    /*
    *---------------------------------------------------------------
    * model method
    *---------------------------------------------------------------
    */
    protected function model($file,$args = []){
        $this->{$file} = new $file($args);
    }
    /*
    *---------------------------------------------------------------
    * library method
    *---------------------------------------------------------------
    */
    protected function library($file,$args = []){
        $this->{$file} = new $file($args);
    }
}