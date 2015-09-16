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
 * get template function
 *---------------------------------------------------------------
 */
if(!function_exists('template')){
    function template(){
        $template = get_config('config')['template'];
        return $template;
    }
}
/*
 *---------------------------------------------------------------
 * get assets function
 *---------------------------------------------------------------
 */
if(!function_exists('assets')){
    function assets($inner_file){
        $assets = get_config('config')['assets'];
        return $assets.$inner_file;
    }
}
/*
 *---------------------------------------------------------------
 * show_error function
 * @param string $handler (default value '404')
 *---------------------------------------------------------------
 */
if(!function_exists('show_error')){
    function show_error($handler = '404'){
        $template = template();
        $header = $template.'static/header'.EXT;
        $content = $template.'pages/error_'.$handler.EXT;
        $footer = $template.'static/footer'.EXT;
        if(file_exists($header) && file_exists($content) && file_exists($footer)){
            include $header;
            include $content;
            include $footer;
        }else{
            exit('Error handler views are missing form app/views/error folder and templates/pages folder');
        }
        exit;
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
        //exit;
    }
}