<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * __autoload function
 * @param string $class
 *---------------------------------------------------------------
 */
if(!function_exists('__autoload')){
    function __autoload($class){
        $path = SYS_PATH;
        if(!file_exists($path.$class.EXT))
            $path = SYS_PATH.'libraries/';
        if(!file_exists($path.$class.EXT))
            $path = APP_PATH.'controllers/';
        if(!file_exists($path.$class.EXT))
            $path = APP_PATH.'models/';
        if(!file_exists($path.$class.EXT))
            $path = APP_PATH.'libraries/';
        require $path.$class.EXT;
    }
}
/*
 *---------------------------------------------------------------
 * get_config function
 * @param string $filename
 *---------------------------------------------------------------
 */
if(!function_exists('get_config')){
    function &get_config($filename){
        $file = APP_PATH.'config/'.$filename.EXT;
        if(file_exists($file)){
            require $file; $name = explode('.',$filename)[0];
            $config = $$name;
            return $config;
        }else{
            exit("Configuration file ".$filename." dose`nt exists in your <b>".APP_PATH."config</b> folder");
        }
    }
}
/*
 *---------------------------------------------------------------
 * debug_print function
 * @param string $filename
 *---------------------------------------------------------------
 */
if(!function_exists('debug_print')){
    function debug_print($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit;
    }
}
/*
 *---------------------------------------------------------------
 * debug_dump function
 * @param string $filename
 *---------------------------------------------------------------
 */
if(!function_exists('debug_dump')){
    function debug_dump($data){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        exit;
    }
}