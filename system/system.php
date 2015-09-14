<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class System{
    /*
    *---------------------------------------------------------------
    * string $url variable
    *---------------------------------------------------------------
    */
    private static $url = '';
    /*
    *---------------------------------------------------------------
    * string $controller variable
    *---------------------------------------------------------------
    */
    private static $controller = '';
    /*
    *---------------------------------------------------------------
    * string $method variable (default value 'index')
    *---------------------------------------------------------------
    */
    private static $method = 'index';
    /*
    *---------------------------------------------------------------
    * array $params variable
    *---------------------------------------------------------------
    */
    private static $params = array();
    /*
    *---------------------------------------------------------------
    * Run method
    *---------------------------------------------------------------
    */
    static public function Run(){
        self::$url = (isset($_GET['url'])) ? trim(stripslashes($_GET['url'])) : '';
        if(self::absolute_address() === false){
            $rout = Rout::init();
            self::$controller   = $rout['controller'];
            self::$method       = $rout['method'];
            self::$params       = $rout['params'];
        }

        $controller = new self::$controller;
        self::checker($controller);
        if (method_exists($controller, self::$method)) {
            if((!empty(self::$params))){
                call_user_func_array(array($controller, self::$method), self::$params);
            }else{
                $controller->{self::$method}();
            }
        }
    }
    /*
    *---------------------------------------------------------------
    * absolute_address method
    * @functionality working with absolute url
        * this will check is controller exists
        * is controller method exits
    *---------------------------------------------------------------
    */
    static private function absolute_address(){
        if(trim(self::$url) != ''){
            $url_parts = explode('/',self::$url);
            if(!file_exists(APP_PATH.'controllers/'.$url_parts[0].EXT)){
                return false;
            }
            self::$controller = $url_parts[0];
            self::$method = (isset($url_parts[1]) && trim($url_parts[1]) != '') ? $url_parts[1] : 'index';
            if(isset($url_parts[2]) && trim($url_parts[2]) != ''){
                for($i = 2; $i < count($url_parts); $i++){
                    array_push(self::$params,$url_parts[$i]);
                }
            }
            return true;
        }
        return false;
    }
    static private function checker($controller){
        $object = new ReflectionClass($controller);
        $method = $object->getMethod(self::$method);
        $params = $method->getParameters();
        if(count(self::$params) != count($params)){
            for($i = 0; $i < count($params); $i++){
                if(!$params[$i]->isDefaultValueAvailable()){
                    if(!isset(self::$params[$params[0]->getPosition()])){
                        exit('<span style="color:darkred;"> '.ucfirst(self::$controller).' controller </span><span style="color:darkorange;">'.self::$method.' method</span> <span style="color:darkgreen">'.$params[$i]->getName().' parameter</span> dose`nt have default value');
                    }
                }
            }
        }
    }
}