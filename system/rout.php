<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class Rout{
    /*
    *---------------------------------------------------------------
    * string $url variable
    *---------------------------------------------------------------
    */
    private static $rout_types;
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
    private static $controller = 'error';
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
        self::$url = (isset($_GET['url'])) ? trim(stripslashes($_GET['url'])) : '';
        self::$routes = get_config('route');

        if(self::by_key() === false){
            if(!self::advanced()){
                exit('Rout <b>'.self::$url."</b> not found in <b>app/config/rout".EXT.'</b> file');
            }
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
            self::explode_rout(self::$routes[self::$url]);
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
        self::$rout_types = get_config_item('route_types');
        $matches = [];
        $url_parts = explode('/',self::$url);
        $url_count = count($url_parts);
        foreach(self::$routes as $key => $value){
            $key_parts = explode('/',$key);
            $key_count = count($key_parts);
            if($key_count == $url_count) {
                for ($i = 0; $i < $key_count; $i++) {
                    if (array_key_exists($key_parts[$i], self::$rout_types)) {
                        if (preg_match(self::$rout_types[$key_parts[$i]], $url_parts[$i])) {
                            $matches[] = $url_parts[$i];
                        } else {
                            exit('Not defined rout type check your app/config/config'.EXT.' $config["route_types"] content');
                        }
                    } else {
                        exit('Not allowed character (s) in url');
                    }
                }
                if (is_callable($value))
                    $value = $value();

                $value_parts = explode('/', $value);
                $val_count = count($value_parts);

                $rout_result = $value_parts[0] . '/' . $value_parts[1];

                for ($j = 2; $j < $val_count; $j++) {
                    $cur_param = str_replace('$', '', $value_parts[$j]);
                    $rout_result .= '/' . $matches[$cur_param - 1];
                }

                self::explode_rout($rout_result);
                break;
            }
        }
        return false;
    }
    /*
    *---------------------------------------------------------------
    * by_key method
    * @param string $key (default value 'default_controller')
    *---------------------------------------------------------------
    */
    static private function explode_rout($key){
        $route_val_parts = explode('/',$key);
        $count = count($route_val_parts);
        self::$controller = $route_val_parts[0];
        if(isset($route_val_parts[1])){
            self::$method = $route_val_parts[1];
            if(isset($route_val_parts[1])){
                for($i = 2; $i < $count; $i++){
                    array_push(self::$params,$route_val_parts[$i]);
                }
            }
        }
    }
}