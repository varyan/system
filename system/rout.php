<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class Rout{
    /*
    *---------------------------------------------------------------
    * string $url variable
    *---------------------------------------------------------------
    */
    private static $rout_types = [
        '(.*)'=>'/^[A-Za-z0-9_\.\-\+\?\/=]/',
        '(.n)'=>'/^[0-9]/',
        '(.s)'=>'/^[a-zA-Z0-9]/',
    ];
    /*
    *---------------------------------------------------------------
    * array $routes variable
    *---------------------------------------------------------------
    */
    private static $routes;
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
    * init method
    *---------------------------------------------------------------
    */
    static public function init(){
        self::$url = (isset($_GET['url'])) ? $_GET['url'] : '';
        self::$routes = get_config('route');

        if(self::by_key() === false){
            self::advanced();
        }

        return [
            'controller'    =>self::$controller,
            'method'        =>self::$method,
            'params'        =>self::$params
        ];
    }
    /*
    *---------------------------------------------------------------
    * by_key method
    *---------------------------------------------------------------
    */
    static private function by_key(){
        if(!array_key_exists(self::$url,self::$routes)){
            if(trim(self::$url) == ''){
                if(array_key_exists('default_controller',self::$routes)){
                    $value = self::$routes['default_controller'];
                    self::explode_rout($value);
                    return true;
                }
            }
        }else{
            self::explode_rout(self::$url);
            return true;
        }
        return false;
    }
    /*
    *---------------------------------------------------------------
    * advanced method
    *---------------------------------------------------------------
    */
    static private function advanced(){
        $url_parts = explode('/',self::$url);
        foreach(self::$routes as $key => $value){
            $key_parts = explode('/',$key);
            if(count($key_parts) == count($url_parts)){
                for($i = 0; $i < count($key_parts); $i++){
                    if(array_key_exists($key_parts[$i],self::$rout_types)){
                        if(preg_match(self::$rout_types[$key_parts[$i]],$url_parts[$i])){
                            if(is_callable($value))
                                $value = $value();
                            $value_parts = explode('/',$value);
                            $rout_result = $value_parts[0].'/'.$value_parts[1];

                            for($j = 2; $j < count($value_parts); $j++){
                                $cur_param =  str_replace('$','',$value_parts[$j]);
                                $rout_result .= '/'.$url_parts[$cur_param - 1];
                            }
                            self::explode_rout($rout_result);
                            break;
                        }else{
                            //not allowed parameter type
                        }
                    }else{
                        //not allowed characters in url
                    }
                }
            }
        }
        return true;
    }
    /*
    *---------------------------------------------------------------
    * by_key method
    * @param string $key (default value 'default_controller')
    *---------------------------------------------------------------
    */
    static private function explode_rout($key){
        $route_val_parts = explode('/',$key);
        self::$controller = $route_val_parts[0];
        if(isset($route_val_parts[1])){
            self::$method = $route_val_parts[1];
            if(isset($route_val_parts[1])){
                for($i = 2; $i < count($route_val_parts); $i++){
                    array_push(self::$params,$route_val_parts[$i]);
                }
            }
        }
    }
}